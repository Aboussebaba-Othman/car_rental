<?php

namespace App\Services;

use App\Models\Reservation;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * PayPal Payment Processing Service
 * 
 * SANDBOX TESTING CONFIGURATION:
 * ------------------------------
 * 1. Create a PayPal Developer account at https://developer.paypal.com
 * 2. Create a Sandbox Business account (to receive payments) and Personal account (to make payments)
 * 3. Create a REST API app in the Developer Dashboard to get your client_id and client_secret
 * 4. Configure your .env file with:
 *    - PAYPAL_MODE=sandbox (use 'live' for production)
 *    - PAYPAL_SANDBOX_CLIENT_ID=your_sandbox_client_id
 *    - PAYPAL_SANDBOX_CLIENT_SECRET=your_sandbox_client_secret
 * 
 * TEST CREDENTIALS (Sandbox):
 * ---------------------------
 * Business Account (Merchant): Create in PayPal Developer Dashboard
 * Personal Account (Customer): Create in PayPal Developer Dashboard
 *   Sample Test Account: sb-47bdi25749497@personal.example.com / 12345678
 *
 * TESTING WORKFLOW:
 * ----------------
 * 1. Make sure app is configured to use 'sandbox' mode
 * 2. Create a reservation and proceed to payment
 * 3. Click "Pay with PayPal" button
 * 4. Use the sandbox personal account credentials to log in
 * 5. Complete the test payment process
 * 6. You will be redirected back to your application
 * 
 * COMMON SANDBOX ISSUES:
 * ---------------------
 * - Make sure your return URLs are publicly accessible (use ngrok for local testing)
 * - Sandbox may occasionally be slow or unresponsive
 * - Ensure your reservation has a positive total_price value (min 0.01)
 */
class PayPalService
{
    private $clientId;
    private $clientSecret;
    private $baseUrl;
    private $accessToken;

    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
        $this->baseUrl = config('services.paypal.mode') === 'sandbox'
            ? 'https://api.sandbox.paypal.com'
            : 'https://api.paypal.com';
    }

    private function getAccessToken()
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->successful()) {
            $this->accessToken = $response->json()['access_token'];
            return $this->accessToken;
        }
        
        Log::error('PayPal OAuth error', $response->json());
        throw new Exception('Failed to get PayPal access token');
    }

    public function createOrder(Reservation $reservation)
    {
        try {
            // Double-check the reservation has a positive total price
            if ($reservation->total_price <= 0) {
                // Fix the price - ensure it's positive
                $vehicle = \App\Models\Vehicle::findOrFail($reservation->vehicle_id);
                $startDate = \Carbon\Carbon::parse($reservation->start_date);
                $endDate = \Carbon\Carbon::parse($reservation->end_date);
                $numberOfDays = max($endDate->diffInDays($startDate), 1); // Ensure at least 1 day
                $totalPrice = $vehicle->price_per_day * $numberOfDays;
                
                // Apply minimum price
                $reservation->total_price = max($totalPrice, 0.01);
                $reservation->save();
                
                Log::warning('Fixed zero or negative reservation price', [
                    'reservation_id' => $reservation->id,
                    'new_price' => $reservation->total_price
                ]);
            }

            $token = $this->getAccessToken();
            
            // Format price properly - ensure it has 2 decimal places and is a string
            // Use max() to ensure the value is at least 0.01 (minimum PayPal amount)
            $formattedPrice = sprintf('%.2f', max($reservation->total_price, 0.01));
            
            // Log the request data for debugging
            Log::info('Creating PayPal order', [
                'reservation_id' => $reservation->id,
                'total_price' => $reservation->total_price,
                'formatted_price' => $formattedPrice,
                'vehicle' => $reservation->vehicle->brand . ' ' . $reservation->vehicle->model
            ]);
            
            $response = Http::withToken($token)
                ->post("{$this->baseUrl}/v2/checkout/orders", [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'reference_id' => (string)$reservation->id,
                            'description' => "Réservation de véhicule - {$reservation->vehicle->brand} {$reservation->vehicle->model}",
                            'amount' => [
                                'currency_code' => 'EUR',
                                'value' => $formattedPrice,
                            ],
                        ],
                    ],
                    'application_context' => [
                        'brand_name' => 'AutoLocPro',
                        'return_url' => route('reservations.paypal.success', ['reservation' => $reservation->id]),
                        'cancel_url' => route('reservations.paypal.cancel', ['reservation' => $reservation->id]),
                    ]
                ]);

            // Log the full response for debugging
            Log::info('PayPal response', ['status' => $response->status(), 'body' => $response->json()]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Save payment ID to reservation
                $reservation->payment_id = $data['id'];
                $reservation->payment_method = 'paypal';
                $reservation->payment_status = 'created';
                $reservation->status = 'payment_pending';
                $reservation->save();

                // Find approval URL
                $approvalUrl = null;
                foreach ($data['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approvalUrl = $link['href'];
                        break;
                    }
                }

                return [
                    'success' => true,
                    'order_id' => $data['id'],
                    'approval_url' => $approvalUrl,
                ];
            }

            Log::error('PayPal Create Order Error', [
                'status' => $response->status(),
                'body' => $response->json(),
                'request_data' => [
                    'reference_id' => $reservation->id,
                    'total_price' => number_format($reservation->total_price, 2, '.', ''),
                    'return_url' => route('reservations.paypal.success', ['reservation' => $reservation->id]),
                    'cancel_url' => route('reservations.paypal.cancel', ['reservation' => $reservation->id]),
                ]
            ]);
            return [
                'success' => false,
                'message' => 'Failed to create PayPal order: ' . ($response->json()['message'] ?? $response->status()),
                'error' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('PayPal Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'message' => 'Exception occurred: ' . $e->getMessage(),
            ];
        }
    }

    public function capturePayment($orderId, Reservation $reservation)
    {
        try {
            // Validate order ID
            if (empty($orderId)) {
                Log::error('PayPal Capture Error: Empty order ID', [
                    'reservation_id' => $reservation->id,
                    'payment_id' => $reservation->payment_id
                ]);
                
                // If the payment_id exists but wasn't passed, use it
                if (!empty($reservation->payment_id)) {
                    $orderId = $reservation->payment_id;
                    Log::info('Using payment_id from reservation', ['payment_id' => $orderId]);
                } else {
                    return [
                        'success' => false,
                        'message' => 'Missing PayPal order ID',
                    ];
                }
            }

            $token = $this->getAccessToken();

            // Log capture attempt
            Log::info('Attempting to capture PayPal payment', [
                'order_id' => $orderId,
                'reservation_id' => $reservation->id
            ]);

            // Make request with proper headers and empty object as the body
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'PayPal-Request-Id' => 'capture-' . $reservation->id . '-' . time(),
                ])
                ->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture", json_decode('{}'));

            // Log full response for debugging
            Log::info('PayPal capture response', [
                'status' => $response->status(),
                'body' => $response->json(),
                'headers' => $response->headers()
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Update reservation with payment details
                $reservation->payment_status = $data['status'];
                $reservation->status = ($data['status'] === 'COMPLETED') ? 'confirmed' : 'payment_pending';
                $reservation->amount_paid = $data['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
                $reservation->payment_date = now();
                $reservation->transaction_id = $data['purchase_units'][0]['payments']['captures'][0]['id'];
                
                if (isset($data['payer'])) {
                    $reservation->payer_id = $data['payer']['payer_id'];
                    $reservation->payer_email = $data['payer']['email_address'];
                }
                
                $reservation->save();

                return [
                    'success' => true,
                    'status' => $data['status'],
                    'transaction_id' => $reservation->transaction_id,
                ];
            }

            // Enhanced error logging with detailed information
            Log::error('PayPal Capture Payment Error', [
                'status_code' => $response->status(),
                'response_body' => $response->json(),
                'order_id' => $orderId,
                'reservation_id' => $reservation->id,
                'url' => "{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture"
            ]);
            
            // Extract meaningful error message if available
            $errorMessage = 'Failed to capture PayPal payment';
            if ($response->json() && isset($response->json()['message'])) {
                $errorMessage .= ': ' . $response->json()['message'];
            } elseif ($response->json() && isset($response->json()['error_description'])) {
                $errorMessage .= ': ' . $response->json()['error_description'];
            } elseif ($response->json() && isset($response->json()['details'][0]['description'])) {
                $errorMessage .= ': ' . $response->json()['details'][0]['description'];
            }
            
            return [
                'success' => false,
                'message' => $errorMessage,
                'error' => $response->json(),
                'status_code' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('PayPal Capture Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $orderId,
                'reservation_id' => $reservation->id
            ]);
            
            return [
                'success' => false,
                'message' => 'Exception during payment capture: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Alternative implementation to capture payment
     * This method uses cURL directly which can sometimes avoid formatting issues
     */
    public function capturePaymentWithCurl($orderId, Reservation $reservation)
    {
        try {
            if (empty($orderId)) {
                if (!empty($reservation->payment_id)) {
                    $orderId = $reservation->payment_id;
                    Log::info('Using payment_id from reservation', ['payment_id' => $orderId]);
                } else {
                    return [
                        'success' => false,
                        'message' => 'Missing PayPal order ID',
                    ];
                }
            }

            $token = $this->getAccessToken();
            
            // Initialize cURL session
            $ch = curl_init("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture");
            
            // Set cURL options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
                'PayPal-Request-Id: capture-' . $reservation->id . '-' . time()
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{}'); // Empty JSON object
            
            // Execute cURL request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // Check for cURL errors
            if (curl_errno($ch)) {
                Log::error('cURL Error', ['error' => curl_error($ch), 'order_id' => $orderId]);
                curl_close($ch);
                return [
                    'success' => false,
                    'message' => 'Connection error: ' . curl_error($ch)
                ];
            }
            
            curl_close($ch);
            
            // Parse response
            $data = json_decode($response, true);
            
            // Log full response
            Log::info('PayPal capture response (cURL)', [
                'status' => $httpCode,
                'body' => $data
            ]);
            
            if ($httpCode >= 200 && $httpCode < 300) {
                // Update reservation with payment details
                $reservation->payment_status = $data['status'];
                $reservation->status = ($data['status'] === 'COMPLETED') ? 'confirmed' : 'payment_pending';
                $reservation->amount_paid = $data['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
                $reservation->payment_date = now();
                $reservation->transaction_id = $data['purchase_units'][0]['payments']['captures'][0]['id'];
                
                if (isset($data['payer'])) {
                    $reservation->payer_id = $data['payer']['payer_id'];
                    $reservation->payer_email = $data['payer']['email_address'];
                }
                
                $reservation->save();
                
                return [
                    'success' => true,
                    'status' => $data['status'],
                    'transaction_id' => $reservation->transaction_id,
                ];
            } else {
                // Extract error message
                $errorMessage = 'Failed to capture PayPal payment';
                if (isset($data['message'])) {
                    $errorMessage .= ': ' . $data['message'];
                } elseif (isset($data['error_description'])) {
                    $errorMessage .= ': ' . $data['error_description'];
                } elseif (isset($data['details'][0]['description'])) {
                    $errorMessage .= ': ' . $data['details'][0]['description'];
                }
                
                Log::error('PayPal Capture Payment Error (cURL)', [
                    'status_code' => $httpCode,
                    'response' => $data,
                    'order_id' => $orderId
                ]);
                
                return [
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => $data,
                    'status_code' => $httpCode
                ];
            }
        } catch (\Exception $e) {
            Log::error('PayPal Capture Exception (cURL)', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $orderId
            ]);
            
            return [
                'success' => false,
                'message' => 'Exception during payment capture: ' . $e->getMessage(),
            ];
        }
    }
}