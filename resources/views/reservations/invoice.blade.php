<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $invoiceNumber }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .invoice-box {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 15px rgba(0, 0, 0, .1);
            background-color: #fff;
            position: relative;
            page-break-after: always;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(234, 179, 8, 0.07);
            font-weight: bold;
            z-index: 0;
            text-transform: uppercase;
        }
        .invoice-header {
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        .logo-container {
            width: 220px;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: #EAB308;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }
        .logo-text {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .logo-text span {
            color: #EAB308;
        }
        .invoice-number {
            text-align: right;
        }
        .invoice-number-label {
            font-size: 20px;
            color: #333;
            margin-bottom: 3px;
        }
        .section {
            margin: 15px 0;
            position: relative;
            z-index: 1;
        }
        .invoice-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
            padding-bottom: 3px;
            border-bottom: 2px solid #EAB308;
            display: inline-block;
        }
        .company-details {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            gap: 20px;
            width: 100%;
            margin-bottom: 15px;
        }
        .address-block {
            width: 47%;
            background-color: #fcfcfc;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
        }
        .info-item {
            margin-bottom: 4px;
            display: flex;
        }
        .info-label {
            font-weight: 600;
            color: #555;
            min-width: 80px;
        }
        .info-value {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table th, table td {
            padding: 8px 6px;
            border-bottom: 1px solid #eee;
            text-align: left;
            font-size: 11px;
        }
        table th {
            background-color: #f8f8f8;
            font-weight: 600;
            color: #555;
        }
        table tr:last-child td {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin-top: 15px;
            text-align: right;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .totals-row {
            margin-bottom: 5px;
        }
        .total-row {
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            padding-top: 5px;
            border-top: 2px solid #EAB308;
        }
        .highlight {
            color: #EAB308;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 9px;
            position: relative;
            z-index: 1;
        }
        .payment-info {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            font-size: 11px;
        }
        .payment-details {
            display: flex;
            justify-content: space-between;
        }
        .payment-left {
            width: 70%;
        }
        .payment-right {
            width: 30%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .legal-mentions {
            margin-top: 15px;
            font-size: 8px;
            color: #999;
            text-align: center;
        }
        .vehicle-details {
            background-color: #f9f9f9;
            border-left: 3px solid #EAB308;
            padding: 8px 10px;
            margin-bottom: 5px;
            font-size: 11px;
        }
        .verification-block {
            text-align: center;
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 8px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .verification-code {
            font-family: monospace;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            letter-spacing: 1px;
        }
        .verification-text {
            font-size: 8px;
            color: #999;
            margin-top: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        @if($reservation->status === 'paid' || $reservation->status === 'completed')
        <div class="watermark">PAYÉE</div>
        @elseif($reservation->status === 'confirmed')
        <div class="watermark">CONFIRMÉE</div>
        @endif
        
        <div class="invoice-header">
            <div class="logo-container">
                <div class="logo">
                    <div class="logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                        </svg>
                    </div>
                    <div class="logo-text">Auto<span>Loc</span>Pro</div>
                </div>
                <div style="font-size: 12px; color: #777; margin-top: 5px;">Location de véhicules premium</div>
            </div>
            <div class="invoice-number">
                <div class="invoice-number-label">FACTURE</div>
                <strong>#{{ $invoiceNumber }}</strong><br>
                Date d'émission: {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br>
                Référence client: CL-{{ str_pad($reservation->user->id, 5, '0', STR_PAD_LEFT) }}
            </div>
        </div>
        
        <div class="section">
            <div class="company-details">
                <div class="address-block">
                    <div class="invoice-title">NOTRE SOCIÉTÉ</div>
                    @if($reservation->vehicle && $reservation->vehicle->company)
                        <div class="info-item">
                            <span class="info-label">Société:</span>
                            <span class="info-value"><strong>{{ $reservation->vehicle->company->company_name }}</strong></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Adresse:</span>
                            <span class="info-value">{{ $reservation->vehicle->company->address }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Ville:</span>
                            <span class="info-value">{{ $reservation->vehicle->company->city }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Téléphone:</span>
                            <span class="info-value">{{ $reservation->vehicle->company->user->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $reservation->vehicle->company->user->email ?? 'N/A' }}</span>
                        </div>
                    @else
                        <div class="info-item">
                            <span class="info-label">Société:</span>
                            <span class="info-value"><strong>AutoLocPro</strong></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Adresse:</span>
                            <span class="info-value">42 Avenue des Champs-Élysées</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Ville:</span>
                            <span class="info-value">75008 Paris</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Téléphone:</span>
                            <span class="info-value">+33 1 42 68 53 00</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value">contact@autoloc.fr</span>
                        </div>
                    @endif
                </div>
        
                <div class="address-block">
                    <div class="invoice-title">FACTURER À</div>
                    <div class="info-item">
                        <span class="info-label">Client:</span>
                        <span class="info-value">
                            <strong>{{ $reservation->user->firstName ?? '' }} {{ $reservation->user->lastName ?? $reservation->user->name }}</strong>
                        </span>
                    </div>
        
                    @if($reservation->driver_name && $reservation->driver_name != $reservation->user->name)
                        <div class="info-item">
                            <span class="info-label">Conducteur:</span>
                            <span class="info-value">{{ $reservation->driver_name }}</span>
                        </div>
                    @endif
        
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $reservation->user->email }}</span>
                    </div>
        
                    @if($reservation->driver_phone)
                        <div class="info-item">
                            <span class="info-label">Téléphone:</span>
                            <span class="info-value">{{ $reservation->driver_phone }}</span>
                        </div>
                    @elseif($reservation->user->phone)
                        <div class="info-item">
                            <span class="info-label">Téléphone:</span>
                            <span class="info-value">{{ $reservation->user->phone }}</span>
                        </div>
                    @endif
        
                    <div class="info-item">
                        <span class="info-label">Client #:</span>
                        <span class="info-value">{{ str_pad($reservation->user->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
        
                    <div class="info-item">
                        <span class="info-label">Date:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="section">
            <div class="invoice-title">DÉTAILS DE LA RÉSERVATION</div>
            
            <div class="vehicle-details">
                <strong>Véhicule:</strong> {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }} ({{ $reservation->vehicle->year }})<br>
                <strong>Immatriculation:</strong> {{ $reservation->vehicle->license_plate }} | 
                <strong>Carburant:</strong> 
                @if($reservation->vehicle->fuel_type === 'gasoline') Essence
                @elseif($reservation->vehicle->fuel_type === 'diesel') Diesel
                @elseif($reservation->vehicle->fuel_type === 'electric') Électrique
                @elseif($reservation->vehicle->fuel_type === 'hybrid') Hybride
                @else {{ ucfirst($reservation->vehicle->fuel_type) }}
                @endif | 
                <strong>Transmission:</strong> 
                @if($reservation->vehicle->transmission === 'automatic') Automatique
                @elseif($reservation->vehicle->transmission === 'manual') Manuelle
                @else {{ ucfirst($reservation->vehicle->transmission) }}
                @endif
            </div>
            
            <table>
                <tr>
                    <th style="width: 50%;">Description</th>
                    <th>Période</th>
                    <th>Tarif journalier</th>
                    <th>Jours</th>
                    <th class="text-right">Montant HT</th>
                </tr>
                <tr>
                    <td>
                        <strong>Location de véhicule</strong><br>
                        {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}
                    </td>
                    <td>
                        Du {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}<br>
                        Au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}
                    </td>
                    <td>{{ number_format($reservation->vehicle->price_per_day / 1.2, 2, ',', ' ') }} €</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1 }}</td>
                    <td class="text-right">
                        {{ number_format(($reservation->vehicle->price_per_day / 1.2) * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1), 2, ',', ' ') }} €
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <strong>Lieux</strong><br>
                        Prise en charge: {{ $reservation->pickup_location }}<br>
                        Retour: {{ $reservation->return_location }}
                    </td>
                    <td colspan="3"></td>
                </tr>
                
                @if($reservation->notes)
                <tr>
                    <td colspan="4">
                        <strong>Notes:</strong><br>
                        {{ $reservation->notes }}
                    </td>
                    <td class="text-right">—</td>
                </tr>
                @endif
            </table>
            
            <div class="totals">
                @php
                    $subtotalHT = ($reservation->vehicle->price_per_day / 1.2) * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1);
                    $discountAmount = 0;
                    if($reservation->promotion) {
                        $discountAmount = $subtotalHT * $reservation->promotion->discount_percentage / 100;
                    }
                    $totalHT = $subtotalHT - $discountAmount;
                    $tva = $totalHT * 0.2;
                    $totalTTC = $totalHT + $tva;
                @endphp
                
                <div class="totals-row">
                    <strong>Sous-total HT:</strong> 
                    {{ number_format($subtotalHT, 2, ',', ' ') }} €
                </div>
                
                @if($reservation->promotion)
                <div class="totals-row" style="color: #22c55e;">
                    <strong>Promotion ({{ $reservation->promotion->name }}):</strong> 
                    -{{ number_format($discountAmount, 2, ',', ' ') }} €
                </div>
                @endif
                
                <div class="totals-row">
                    <strong>Total HT:</strong> 
                    {{ number_format($totalHT, 2, ',', ' ') }} €
                </div>
                
                
                <div class="total-row">
                    <strong>Total TTC:</strong> 
                    <span class="highlight">{{ number_format($totalTTC, 2, ',', ' ') }} €</span>
                </div>
            </div>
        </div>
        
        <div class="section payment-info">
            <div class="invoice-title">INFORMATIONS DE PAIEMENT</div>
            
            <div class="payment-details">
                <div class="payment-left">
                    <strong>Statut:</strong> 
                    @if($reservation->status === 'paid') <span style="color: #22c55e;">Payée</span>
                    @elseif($reservation->status === 'confirmed') <span style="color: #3b82f6;">Confirmée</span>
                    @elseif($reservation->status === 'completed') <span style="color: #6b7280;">Terminée</span>
                    @endif
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    
                    <strong>Mode de paiement:</strong> 
                    @if($reservation->payment_method === 'credit_card') Carte bancaire
                    @elseif($reservation->payment_method === 'paypal') PayPal
                    @else {{ ucfirst($reservation->payment_method ?? 'Non spécifié') }}
                    @endif
                    
                    @if($reservation->transaction_id)
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <strong>Réf. transaction:</strong> {{ $reservation->transaction_id }}
                    @endif
                    
                    @if($reservation->payment_date)
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <strong>Date de paiement:</strong> {{ \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y') }}
                    @endif
                </div>
                
                <div class="payment-right">
                    <div class="verification-block">
                        <div class="verification-code">{{ strtoupper(substr(md5($invoiceNumber . $reservation->id), 0, 10)) }}</div>
                        <div class="verification-text">Facture #{{ $invoiceNumber }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div style="text-align: center; margin-bottom: 5px;">
                Nous vous remercions pour votre confiance. Pour toute question, contactez-nous au
                @if($reservation->vehicle && $reservation->vehicle->company && $reservation->vehicle->company->user && $reservation->vehicle->company->user->phone)
                {{ $reservation->vehicle->company->user->phone }}
                @else
                +33 1 42 68 53 00
                @endif
            </div>
            
            <div class="legal-mentions">
                @if($reservation->vehicle && $reservation->vehicle->company)
                {{ $reservation->vehicle->company->company_name ?? 'AutoLocPro' }} - 
                {{ $reservation->vehicle->company->address ?? '42 Avenue des Champs-Élysées' }}, 
                {{ $reservation->vehicle->company->city ?? '75008 Paris' }} | 
                SIRET: 879 456 213 00037 | N° TVA: FR 27 879456213<br>
                @else
                AutoLocPro - 42 Avenue des Champs-Élysées, 75008 Paris | SIRET: 879 456 213 00037 | N° TVA: FR 27 879456213<br>
                @endif
                Conditions: paiement à réception. Retard: 3× taux d'intérêt légal (loi 2008-776) + indemnité forfaitaire 40€.
            </div>
        </div>
    </div>
</body>
</html>
