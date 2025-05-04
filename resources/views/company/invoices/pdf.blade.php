<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #FAC-{{ $reservation->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            padding: 20px 0;
            border-bottom: 1px solid #ddd;
        }
        .company-info {
            float: left;
            width: 50%;
        }
        .invoice-info {
            float: right;
            width: 50%;
            text-align: right;
        }
        .customer-info {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .subtotal {
            margin-top: 20px;
            text-align: right;
        }
        .total {
            margin-top: 10px;
            font-weight: bold;
            text-align: right;
            font-size: 14px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header clearfix">
            <div class="company-info">
                <h2>{{ $company->name }}</h2>
                <p>{{ $company->address }}<br>
                {{ $company->city }}, {{ $company->postal_code }}<br>
                {{ $company->phone }}<br>
                {{ $company->email }}</p>
            </div>
            
            <div class="invoice-info">
                <h1>FACTURE</h1>
                <p>Numéro de facture: FAC-{{ $reservation->id }}<br>
                Date d'émission: {{ now()->format('d/m/Y') }}<br>
                Date d'échéance: {{ now()->addDays(7)->format('d/m/Y') }}</p>
                
                <p>Statut: 
                @if(in_array($reservation->status, ['confirmed', 'paid', 'completed'])) 
                    PAYÉ
                @else 
                    EN ATTENTE
                @endif
                </p>
                
                @if($reservation->payment_date)
                <p>Date de paiement: {{ \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>
        
        <div class="customer-info">
            <h3>Facturer à:</h3>
            <p>{{ $reservation->user->name }}<br>
            {{ $reservation->user->email }}<br>
            @if($reservation->user->phone)
            {{ $reservation->user->phone }}
            @endif
            </p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Détails</th>
                    <th>Durée</th>
                    <th style="text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Location de Véhicule</strong><br>
                        {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}<br>
                        Plaque d'immatriculation: {{ $reservation->vehicle->license_plate }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }} jour(s)<br>
                        {{ number_format($reservation->vehicle->price_per_day, 2) }} € / jour
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1), 2) }} €
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="subtotal">
            <p>Sous-total: {{ number_format($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1), 2) }} €</p>
            
            @if($reservation->promotion)
            <p style="color: green;">
                {{ $reservation->promotion->name }} ({{ $reservation->promotion->discount_percentage }}% de réduction):
                -{{ number_format(($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1)) * ($reservation->promotion->discount_percentage / 100), 2) }} €
            </p>
            @endif
        </div>
        
        <div class="total">
            <p>Total: {{ number_format($reservation->total_price, 2) }} €</p>
        </div>
        
        <div style="margin-top: 30px;">
            <p><strong>Mode de paiement:</strong> 
                @if($reservation->payment_method == 'paypal')
                    PayPal
                @elseif($reservation->payment_method == 'manual')
                    Paiement Manuel
                @elseif($reservation->payment_method == 'credit_card')
                    Carte de Crédit
                @elseif($reservation->payment_method)
                    {{ ucfirst($reservation->payment_method) }}
                @else
                    En attente
                @endif
            </p>
            
            @if($reservation->transaction_id)
            <p><strong>ID de transaction:</strong> {{ $reservation->transaction_id }}</p>
            @endif
        </div>
        
        <div style="margin-top: 30px; padding: 15px; background-color: #f5f5f5;">
            <h3>Détails de la Réservation</h3>
            
            <div style="width: 48%; float: left;">
                <p><strong>Lieu de prise en charge:</strong><br>
                {{ $reservation->pickup_location }}</p>
                
                <p><strong>Date et heure de prise en charge:</strong><br>
                {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y H:i') }}</p>
                
                <p><strong>Lieu de retour:</strong><br>
                {{ $reservation->return_location }}</p>
            </div>
            
            <div style="width: 48%; float: right;">
                <p><strong>Date et heure de retour:</strong><br>
                {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y H:i') }}</p>
                
                <p><strong>Notes supplémentaires:</strong><br>
                {{ $reservation->notes ?: 'Aucune note supplémentaire fournie.' }}</p>
            </div>
            <div style="clear: both;"></div>
        </div>
        
        <div class="footer">
            <p>Merci d'avoir choisi {{ $company->name }}!</p>
            <p>Pour toute question concernant cette facture, veuillez nous contacter à {{ $company->email }}.</p>
            
            <div style="margin-top: 20px;">
                <h4>Termes et Conditions</h4>
                <ul style="list-style: disc; padding-left: 20px; text-align: left;">
                    <li>Le paiement est dû dans les 7 jours suivant la date de facturation.</li>
                    <li>Les retours tardifs peuvent être soumis à des frais supplémentaires.</li>
                    <li>Le véhicule doit être retourné dans le même état que celui reçu.</li>
                    <li>Le carburant doit être au même niveau qu'au moment de la prise en charge.</li>
                    <li>Pour les annulations, veuillez consulter notre politique d'annulation.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
