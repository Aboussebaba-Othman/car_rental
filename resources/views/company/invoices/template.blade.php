@extends('layouts.company')

@section('title', 'Invoice')
@section('header', 'Invoice')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Invoice #INV-{{ $reservation->id }}</h2>
    
    <div>
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Invoice
        </button>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Invoice Header -->
    <div class="p-6 pb-0">
        <div class="flex justify-between">
            <!-- Company Info -->
            <div class="mb-8">
                <div class="flex items-center mb-2">
                    <div class="bg-blue-600 p-2 rounded-lg shadow-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-wider">{{ $company->name }}</span>
                </div>
                <p class="text-gray-500">{{ $company->address }}</p>
                <p class="text-gray-500">{{ $company->city }}, {{ $company->postal_code }}</p>
                <p class="text-gray-500">{{ $company->phone }}</p>
                <p class="text-gray-500">{{ $company->email }}</p>
            </div>
            
            <!-- Invoice Info -->
            <div class="text-right">
                <div class="text-xl font-bold text-gray-800 mb-2">INVOICE</div>
                <div class="text-sm text-gray-500 mb-1">Invoice Number: <span class="font-medium text-gray-800">INV-{{ $reservation->id }}</span></div>
                <div class="text-sm text-gray-500 mb-1">Date: <span class="font-medium text-gray-800">{{ now()->format('d/m/Y') }}</span></div>
                <div class="text-sm text-gray-500 mb-1">Invoice Status: 
                    <span class="inline-flex px-2 text-xs font-semibold rounded-full
                        @if(in_array($reservation->status, ['confirmed', 'paid', 'completed'])) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                        @if(in_array($reservation->status, ['confirmed', 'paid', 'completed'])) PAID @else PENDING @endif
                    </span>
                </div>
                @if($reservation->payment_date)
                <div class="text-sm text-gray-500">Payment Date: <span class="font-medium text-gray-800">{{ Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y') }}</span></div>
                @endif
            </div>
        </div>
        
        <!-- Customer Info -->
        <div class="mb-8">
            <h3 class="text-gray-600 font-medium mb-2">Bill To:</h3>
            <div class="text-gray-800 font-medium">{{ $reservation->user->name }}</div>
            <div class="text-gray-500">{{ $reservation->user->email }}</div>
            @if($reservation->user->phone)
            <div class="text-gray-500">{{ $reservation->user->phone }}</div>
            @endif
        </div>
    </div>
    
    <!-- Invoice Details -->
    <div class="px-6">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="w-full h-16 border-b border-gray-200">
                    <th class="text-left pl-4 text-sm font-medium text-gray-600 uppercase tracking-wider">Description</th>
                    <th class="text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Details</th>
                    <th class="text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Duration</th>
                    <th class="text-right pr-4 text-sm font-medium text-gray-600 uppercase tracking-wider">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="pl-4 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Vehicle Rental</div>
                        <div class="text-sm text-gray-500">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</div>
                    </td>
                    <td class="py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-500">License Plate: {{ $reservation->vehicle->license_plate }}</div>
                    </td>
                    <td class="py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ Carbon\Carbon::parse($reservation->start_date)->diffInDays(Carbon\Carbon::parse($reservation->end_date)) + 1 }} day(s)</div>
                        <div class="text-sm text-gray-500">{{ number_format($reservation->vehicle->price_per_day, 2) }} € / day</div>
                    </td>
                    <td class="pr-4 py-4 whitespace-nowrap text-right">
                        <div class="text-sm font-medium text-gray-900">{{ number_format($reservation->vehicle->price_per_day * (Carbon\Carbon::parse($reservation->start_date)->diffInDays(Carbon\Carbon::parse($reservation->end_date)) + 1), 2) }} €</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Invoice Summary -->
    <div class="p-6">
        <div class="border-t border-gray-200 pt-4">
            <div class="flex justify-between mb-2">
                <div class="text-sm text-gray-600">Subtotal:</div>
                <div class="text-sm font-medium text-gray-900">{{ number_format($reservation->vehicle->price_per_day * (Carbon\Carbon::parse($reservation->start_date)->diffInDays(Carbon\Carbon::parse($reservation->end_date)) + 1), 2) }} €</div>
            </div>
            
            @if($reservation->promotion)
            <div class="flex justify-between mb-2">
                <div class="text-sm text-green-600">{{ $reservation->promotion->name }} ({{ $reservation->promotion->discount_percentage }}% off):</div>
                <div class="text-sm font-medium text-green-600">-{{ number_format(($reservation->vehicle->price_per_day * (Carbon\Carbon::parse($reservation->start_date)->diffInDays(Carbon\Carbon::parse($reservation->end_date)) + 1)) * ($reservation->promotion->discount_percentage / 100), 2) }} €</div>
            </div>
            @endif
            
            <div class="flex justify-between font-bold border-t border-gray-200 pt-2 mb-2">
                <div class="text-gray-800">Total:</div>
                <div class="text-xl text-gray-800">{{ number_format($reservation->total_price, 2) }} €</div>
            </div>
            
            <div class="flex justify-between mt-4">
                <div class="text-gray-600 text-sm font-medium">Payment Method:</div>
                <div class="text-gray-800 text-sm font-medium">
                    @if($reservation->payment_method == 'paypal')
                        PayPal
                    @elseif($reservation->payment_method == 'manual')
                        Manual Payment
                    @elseif($reservation->payment_method)
                        {{ ucfirst($reservation->payment_method) }}
                    @else
                        Pending
                    @endif
                </div>
            </div>
            
            @if($reservation->transaction_id)
            <div class="flex justify-between mt-1">
                <div class="text-gray-600 text-sm font-medium">Transaction ID:</div>
                <div class="text-gray-800 text-sm font-medium">{{ $reservation->transaction_id }}</div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Additional Information -->
    <div class="p-6 bg-gray-50 border-t border-gray-200">
        <h3 class="text-lg font-medium text-gray-800 mb-3">Reservation Details</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 mb-1">Pickup Location:</p>
                <p class="text-sm font-medium mb-3">{{ $reservation->pickup_location }}</p>
                
                <p class="text-sm text-gray-600 mb-1">Return Location:</p>
                <p class="text-sm font-medium">{{ $reservation->return_location }}</p>
            </div>
            
            <div>
                <p class="text-sm text-gray-600 mb-1">Additional Notes:</p>
                <p class="text-sm">{{ $reservation->notes ?: 'No additional notes provided.' }}</p>
            </div>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Thank you for choosing {{ $company->name }}!</p>
            <p class="mt-1">For any questions regarding this invoice, please contact us at {{ $company->email }}.</p>
        </div>
    </div>
</div>

<!-- Print Styles - Only applied when printing -->
<style>
    @media print {
        body {
            background-color: white;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        button {
            display: none !important;
        }
        
        .shadow-md {
            box-shadow: none !important;
        }
        
        .rounded-lg {
            border-radius: 0 !important;
        }
        
        @page {
            margin: 0.5cm;
        }
    }
</style>
@endsection