@extends('layouts.company')

@section('title', 'Invoice')
@section('header', 'Invoice')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Invoice #INV-{{ $reservation->id }}</h2>
    
    <div class="flex space-x-3">
        <button onclick="downloadPdf()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Télécharger PDF
        </button>
    </div>
</div>

<div id="invoice-container" class="bg-white rounded-lg shadow-md overflow-hidden print:shadow-none print:border print:border-gray-200">
    <!-- Invoice Header -->
    <div class="p-6 pb-0">
        <div class="flex flex-col md:flex-row justify-between">
            <!-- Company Info -->
            <div class="mb-8">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-600 p-2 rounded-lg shadow-lg mr-3 company-logo">
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
            
            <!-- Information de Facture -->
            <div class="text-left md:text-right">
                <div class="text-2xl font-bold text-gray-800 mb-3">FACTURE</div>
                <div class="text-sm text-gray-500 mb-2">Numéro de Facture: <span class="font-medium text-gray-800">FAC-{{ $reservation->id }}</span></div>
                <div class="text-sm text-gray-500 mb-2">Date d'émission: <span class="font-medium text-gray-800">{{ now()->format('d/m/Y') }}</span></div>
                <div class="text-sm text-gray-500 mb-2">Date d'échéance: <span class="font-medium text-gray-800">{{ now()->addDays(7)->format('d/m/Y') }}</span></div>
                <div class="text-sm text-gray-500 mb-2">Statut de la Facture: 
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        @if(in_array($reservation->status, ['confirmed', 'paid', 'completed'])) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                        @if(in_array($reservation->status, ['confirmed', 'paid', 'completed'])) PAYÉ @else EN ATTENTE @endif
                    </span>
                </div>
                @if($reservation->payment_date)
                <div class="text-sm text-gray-500">Date de paiement: <span class="font-medium text-gray-800">{{ Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y') }}</span></div>
                @endif
            </div>
        </div>
        
        <!-- Customer Info -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
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
                <tr class="w-full h-16 border-b border-gray-200 bg-gray-50">
                    <th class="text-left pl-4 text-sm font-medium text-gray-600 uppercase tracking-wider">Description</th>
                    <th class="text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Details</th>
                    <th class="text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Duration</th>
                    <th class="text-right pr-4 text-sm font-medium text-gray-600 uppercase tracking-wider">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-100">
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
            
            <div class="flex justify-between font-bold border-t border-gray-200 pt-2 mt-2 mb-2">
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
                    @elseif($reservation->payment_method == 'credit_card')
                        Credit Card
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
                
                <p class="text-sm text-gray-600 mb-1">Pickup Date & Time:</p>
                <p class="text-sm font-medium mb-3">{{ Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y H:i') }}</p>
                
                <p class="text-sm text-gray-600 mb-1">Return Location:</p>
                <p class="text-sm font-medium">{{ $reservation->return_location }}</p>
            </div>
            
            <div>
                <p class="text-sm text-gray-600 mb-1">Return Date & Time:</p>
                <p class="text-sm font-medium mb-3">{{ Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y H:i') }}</p>
                
                <p class="text-sm text-gray-600 mb-1">Additional Notes:</p>
                <p class="text-sm">{{ $reservation->notes ?: 'No additional notes provided.' }}</p>
            </div>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Thank you for choosing {{ $company->name }}!</p>
            <p class="mt-1">For any questions regarding this invoice, please contact us at {{ $company->email }}.</p>
        </div>
    </div>
    
    <!-- Termes et Conditions -->
    <div class="p-6 border-t border-gray-200">
        <h3 class="text-lg font-medium text-gray-800 mb-3">Termes et Conditions</h3>
        <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
            <li>Le paiement est dû dans les 7 jours suivant la date de facturation.</li>
            <li>Les retours tardifs peuvent être soumis à des frais supplémentaires.</li>
            <li>Le véhicule doit être retourné dans le même état que celui reçu.</li>
            <li>Le carburant doit être au même niveau qu'au moment de la prise en charge.</li>
            <li>Pour les annulations, veuillez consulter notre politique d'annulation.</li>
        </ul>
    </div>
</div>

<style>
    @media print {
        body {
            background-color: white;
            font-size: 11pt;
            color: #333;
        }
        
        #invoice-container {
            max-width: 100%;
            margin: 0;
            padding: 0;
            border: 1px solid #ddd;
            box-shadow: none;
        }
        
        header, nav, footer, .mb-6, .print-hidden {
            display: none !important;
        }
        
        .rounded-lg {
            border-radius: 0 !important;
        }
        
        #invoice-container {
            width: 100%;
            box-shadow: none;
            position: absolute;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        
        .company-logo {
            background-color: #1e40af !important;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
        
        @page {
            margin: 0.5cm;
            size: A4;
        }
        
        .print-hidden {
            display: none !important;
        }
    }
        
    .currency-eur:after {
        content: " €";
    }
</style>

<script>
    function downloadPdf() {
        // Créer un élément temporaire pour la requête AJAX
        var element = document.createElement('div');
        element.innerHTML = '<form action="{{ route("company.invoices.download", $reservation->id) }}" method="POST">' +
            '@csrf<input type="hidden" name="reservation_id" value="{{ $reservation->id }}">' +
            '</form>';
        document.body.appendChild(element);
        element.firstChild.submit();
        document.body.removeChild(element);
    }
    
    // Configurer la fonction d'impression pour n'imprimer que la facture
    function printInvoice() {
        window.print();
    }
</script>
@endsection