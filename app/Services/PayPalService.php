<?php

namespace App\Services;

use App\Models\Reservation;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


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
        if ($reservation->total_price <= 0) {
            $vehicle = \App\Models\Vehicle::findOrFail($reservation->vehicle_id);
            $startDate = \Carbon\Carbon::parse($reservation->start_date);
            $endDate = \Carbon\Carbon::parse($reservation->end_date);
            $numberOfDays = max($endDate->diffInDays($startDate) + 1, 1); // Ajout du +1 ici
            $totalPrice = $vehicle->price_per_day * $numberOfDays;
            
            $reservation->total_price = max($totalPrice, 0.01);
            $reservation->save();
            
            Log::warning('Fixed zero or negative reservation price', [
                'reservation_id' => $reservation->id,
                'new_price' => $reservation->total_price
            ]);
        }

        $token = $this->getAccessToken();
        
        
        $formattedPrice = sprintf('%.2f', max($reservation->total_price, 0.01));
        
        Log::info('Creating PayPal order', [
            'reservation_id' => $reservation->id,
            'total_price' => $reservation->total_price,
            'formatted_price' => $formattedPrice,
            'vehicle' => $reservation->vehicle->brand . ' ' . $reservation->vehicle->model,
            'start_date' => $reservation->start_date,
            'end_date' => $reservation->end_date,
            'number_of_days' => \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1
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

        Log::info('PayPal response', ['status' => $response->status(), 'body' => $response->json()]);

        if ($response->successful()) {
            $data = $response->json();
            
            $reservation->payment_id = $data['id'];
            $reservation->payment_method = 'paypal';
            $reservation->payment_status = 'created';
            $reservation->status = 'payment_pending';
            $reservation->save();

            $approvalUrl = null;
            foreach ($data['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    $approvalUrl = $link['href'];
                    break;
                }
            }

            Log::info('PayPal order created successfully', [
                'order_id' => $data['id'],
                'reservation_id' => $reservation->id,
                'total_price' => $formattedPrice,
                'currency' => 'EUR'
            ]);

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
                'total_price' => $formattedPrice,
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
            if (empty($orderId)) {
                Log::error('PayPal Capture Error: Empty order ID', [
                    'reservation_id' => $reservation->id,
                    'payment_id' => $reservation->payment_id
                ]);
                
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

            Log::info('Attempting to capture PayPal payment', [
                'order_id' => $orderId,
                'reservation_id' => $reservation->id
            ]);

            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'PayPal-Request-Id' => 'capture-' . $reservation->id . '-' . time(),
                ])
                ->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture", json_decode('{}'));

            Log::info('PayPal capture response', [
                'status' => $response->status(),
                'body' => $response->json(),
                'headers' => $response->headers()
            ]);

            if ($response->successful()) {
                $data = $response->json();

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

            Log::error('PayPal Capture Payment Error', [
                'status_code' => $response->status(),
                'response_body' => $response->json(),
                'order_id' => $orderId,
                'reservation_id' => $reservation->id,
                'url' => "{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture"
            ]);
            
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
            
            $ch = curl_init("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture");
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
                'PayPal-Request-Id: capture-' . $reservation->id . '-' . time()
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{}'); // Empty JSON object
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                Log::error('cURL Error', ['error' => curl_error($ch), 'order_id' => $orderId]);
                curl_close($ch);
                return [
                    'success' => false,
                    'message' => 'Connection error: ' . curl_error($ch)
                ];
            }
            
            curl_close($ch);
            
            $data = json_decode($response, true);
            
            Log::info('PayPal capture response (cURL)', [
                'status' => $httpCode,
                'body' => $data
            ]);
            
            if ($httpCode >= 200 && $httpCode < 300) {
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