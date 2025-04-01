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
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture");

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

        Log::error('PayPal Capture Payment Error', $response->json());
        return [
            'success' => false,
            'message' => 'Failed to capture PayPal payment',
            'error' => $response->json(),
        ];
    }
}
