@extends('layouts.company')

@section('title', 'Reservation Details')
@section('header', 'Reservation Details')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Reservation #{{ $reservation->id }}</h2>
                <p class="mt-1 text-sm text-gray-600">Created on {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y \a\t H:i') }}</p>
            </div>
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                @if($reservation->status == 'confirmed') bg-green-100 text-green-800 
                @elseif($reservation->status == 'pending') bg-yellow-100 text-yellow-800 
                @elseif($reservation->status == 'payment_pending') bg-blue-100 text-blue-800
                @elseif($reservation->status == 'canceled') bg-red-100 text-red-800
                @elseif($reservation->status == 'completed') bg-gray-100 text-gray-800
                @elseif($reservation->status == 'paid') bg-green-100 text-green-800
                @endif">
                @if($reservation->status == 'confirmed') Confirmed
                @elseif($reservation->status == 'pending') Pending
                @elseif($reservation->status == 'payment_pending') Payment Pending
                @elseif($reservation->status == 'canceled') Canceled
                @elseif($reservation->status == 'completed') Completed
                @elseif($reservation->status == 'paid') Paid
                @else {{ ucfirst($reservation->status) }}
                @endif
            </span>
        </div>
        
        <nav class="flex mt-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('company.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('company.reservations.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Reservations</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Reservation #{{ $reservation->id }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Vehicle Info Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="border-b border-gray-200">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Vehicle Information</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="aspect-w-16 aspect-h-9 mb-4">
                    @if($reservation->vehicle->photos->count() > 0)
                        @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                        <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" class="w-full h-48 object-cover rounded-md">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                
                <h4 class="text-lg font-bold text-gray-900 mb-4">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }} ({{ $reservation->vehicle->year }})</h4>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">License Plate</p>
                        <p class="font-medium">{{ $reservation->vehicle->license_plate }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Seats</p>
                        <p class="font-medium">{{ $reservation->vehicle->seats }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Transmission</p>
                        <p class="font-medium">{{ ucfirst($reservation->vehicle->transmission) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Fuel Type</p>
                        <p class="font-medium">{{ ucfirst($reservation->vehicle->fuel_type) }}</p>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-gray-500 text-sm mb-2">Daily Rate</p>
                    <p class="text-xl font-bold text-blue-600">{{ number_format($reservation->vehicle->price_per_day, 2) }} €</p>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('company.vehicles.show', $reservation->vehicle) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View complete vehicle details →
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Customer Info Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="border-b border-gray-200">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 h-16 w-16">
                        <img class="h-16 w-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($reservation->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $reservation->user->name }}">
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900">{{ $reservation->user->name }}</h4>
                        <p class="text-sm text-gray-500">Customer since {{ \Carbon\Carbon::parse($reservation->user->created_at)->format('M Y') }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Email Address</p>
                        <p class="font-medium">{{ $reservation->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone Number</p>
                        <p class="font-medium">{{ $reservation->user->phone ?? 'Not provided' }}</p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h5 class="text-sm font-medium text-gray-700 mb-3">Previous Reservations</h5>
                    
                    @php
                    $previousReservations = $reservation->user->reservations()
                        ->where('id', '!=', $reservation->id)
                        ->latest()
                        ->take(3)
                        ->get();
                    @endphp
                    
                    @if($previousReservations->count() > 0)
                        <div class="space-y-3">
                            @foreach($previousReservations as $prevReservation)
                                <div class="flex items-center justify-between text-sm">
                                    <div>
                                        <span class="font-medium">{{ $prevReservation->vehicle->brand }} {{ $prevReservation->vehicle->model }}</span>
                                        <div class="text-gray-500">{{ \Carbon\Carbon::parse($prevReservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($prevReservation->end_date)->format('d/m/Y') }}</div>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($prevReservation->status == 'confirmed') bg-green-100 text-green-800 
                                        @elseif($prevReservation->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($prevReservation->status == 'payment_pending') bg-blue-100 text-blue-800
                                        @elseif($prevReservation->status == 'canceled') bg-red-100 text-red-800
                                        @elseif($prevReservation->status == 'completed') bg-gray-100 text-gray-800
                                        @elseif($prevReservation->status == 'paid') bg-green-100 text-green-800
                                        @endif">
                                        {{ ucfirst($prevReservation->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm italic">No previous reservations found.</p>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('company.customers.show', $reservation->user->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View customer profile →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reservation Details Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="border-b border-gray-200">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Reservation Details</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Rental Period</h4>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Pick-up Date</div>
                                <div class="font-medium">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Return Date</div>
                                <div class="font-medium">{{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="mt-3 text-sm text-blue-800 font-medium">
                            Total: {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }} days
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Pickup & Return Locations</h4>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Pickup Location</p>
                            <p class="font-medium">{{ $reservation->pickup_location }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Return Location</p>
                            <p class="font-medium">{{ $reservation->return_location }}</p>
                        </div>
                    </div>
                </div>
                
                @if($reservation->notes)
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Customer Notes</h4>
                    <div class="bg-gray-50 p-3 rounded-lg text-sm">
                        {{ $reservation->notes }}
                    </div>
                </div>
                @endif
                
                <div class="border-t border-gray-200 pt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Pricing Summary</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Daily Rate</span>
                            <span>{{ number_format($reservation->vehicle->price_per_day, 2) }} €</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Number of Days</span>
                            <span>{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }}</span>
                        </div>
                        
                        @if($reservation->promotion)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span>{{ number_format($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1), 2) }} €</span>
                        </div>
                        <div class="flex justify-between text-green-600">
                            <span>Promotion ({{ $reservation->promotion->name }}, {{ $reservation->promotion->discount_percentage }}%)</span>
                            <span>-{{ number_format(($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1)) * ($reservation->promotion->discount_percentage / 100), 2) }} €</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between font-bold pt-2 border-t">
                            <span>Total Amount</span>
                            <span>{{ number_format($reservation->total_price, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payment & Status Information -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
        <div class="border-b border-gray-200">
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
            </div>
        </div>
        
        <div class="p-6">
            @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']) && $reservation->payment_method)
                <div class="bg-green-50 p-4 rounded-lg border border-green-100 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-green-800">Payment Completed</h3>
                            <p class="text-green-600">The customer's payment has been successfully processed.</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Payment Details</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <p class="text-sm text-gray-500">Payment Method</p>
                                    <p class="font-medium">
                                        @if($reservation->payment_method == 'paypal')
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-700 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.59 2.935-3.262 4.58-7.13 4.58H11.13c-.133 0-.235.053-.293.15a.504.504 0 0 0-.098.256l-.771 4.883c-.033.184-.232.496-.532.496H7.149c-.115 0-.263-.143-.263-.261-.004-.031-.004-.063 0-.094l.64-4.01c.024-.138.114-.354.298-.385a1 1 0 0 1 .13-.008h1.052c3.242 0 5.799-1.312 6.913-5.097.193-.645.261-1.22.275-1.688.125-.051.26-.14.331-.185z" />
                                                </svg>
                                                PayPal
                                            </div>
                                        @else
                                            {{ ucfirst($reservation->payment_method) }}
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Payment Date</p>
                                    <p class="font-medium">{{ $reservation->payment_date ? \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Transaction ID</p>
                                    <p class="font-medium">{{ $reservation->transaction_id ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Payment Status</p>
                                    <p class="font-medium text-green-600">{{ $reservation->payment_status ?? 'Completed' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Payment Amount</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Amount Paid</p>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($reservation->amount_paid ?? $reservation->total_price, 2) }} €</p>
                            </div>
                            
                            <div>
                                <a href="{{ route('company.reservations.invoice', $reservation) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    View Invoice
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            
            @elseif(in_array($reservation->status, ['pending', 'payment_pending']))
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-yellow-800">Payment Pending</h3>
                            <p class="text-yellow-600">The customer has not completed payment for this reservation yet.</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Payment Status</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium text-yellow-600">Awaiting Payment</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Total Amount Due</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($reservation->total_price, 2) }} €</p>
                            </div>
                            
                            <div class="text-sm text-gray-500">
                                <p>A payment link has been sent to the customer's email address.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Payment Actions</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500 mb-3">Send payment reminder to customer:</p>
                                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Send Reminder Email
                                    </button>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 mb-3">Or manually mark payment as received:</p>
                                    <form method="POST" action="{{ route('company.reservations.mark-paid', $reservation) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Mark as Paid
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($reservation->status === 'canceled')
                <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-red-800">Reservation Canceled</h3>
                            <p class="text-red-600">This reservation has been canceled {{ $reservation->canceled_at ? 'on ' . \Carbon\Carbon::parse($reservation->canceled_at)->format('d/m/Y') : '' }}.</p>
                        </div>
                    </div>
                    
                    @if($reservation->cancellation_reason)
                        <div class="mt-4 text-sm text-red-700">
                            <p class="font-medium">Cancellation Reason:</p>
                            <p class="mt-1">{{ $reservation->cancellation_reason }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
    
    <!-- Company Comments Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
        <div class="border-b border-gray-200">
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900">Internal Notes</h3>
            </div>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <form method="POST" action="{{ route('company.reservations.add-note', $reservation) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Add Note</label>
                        <textarea id="note" name="note" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Add internal notes about this reservation..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Note
                        </button>
                    </div>
                </form>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-3">Previous Notes</h4>
                
                @if(isset($reservation->notes_history) && count($reservation->notes_history) > 0)
                    <div class="space-y-4">
                        @foreach($reservation->notes_history as $note)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-full mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $note->user->name }}">
                                        <div>
                                            <p class="font-medium">{{ $note->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 text-sm">
                                    {{ $note->content }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm italic">No notes available for this reservation.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Activity Log -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6 mb-6">
        <div class="border-b border-gray-200">
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900">Activity Log</h3>
            </div>
        </div>
        
        <div class="p-6">
            @if(isset($reservation->activities) && count($reservation->activities) > 0)
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($reservation->activities as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                                @if($activity->type === 'status_change') bg-blue-500
                                                @elseif($activity->type === 'payment') bg-green-500
                                                @elseif($activity->type === 'note') bg-yellow-500
                                                @elseif($activity->type === 'cancellation') bg-red-500
                                                @else bg-gray-500
                                                @endif">
                                                @if($activity->type === 'status_change')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                @elseif($activity->type === 'payment')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                @elseif($activity->type === 'note')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                @elseif($activity->type === 'cancellation')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">{{ $activity->description }}</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <p>{{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y H:i') }}</p>
                                                @if($activity->user)
                                                    <p class="text-xs">by {{ $activity->user->name }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-gray-500 text-sm italic">No activity recorded for this reservation.</p>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Any JavaScript functionality specific to this page
    });
</script>
@endsection