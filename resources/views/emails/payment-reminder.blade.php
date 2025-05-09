<!DOCTYPE html>
<html>
<head>
    <title>Rappel de paiement</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2563eb;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        .highlight {
            background-color: #f7f7f7;
            border-left: 4px solid #2563eb;
            padding: 15px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 0.9em;
            color: #6b7280;
        }
        .info {
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <h1>Rappel de paiement pour votre réservation</h1>
    
    <p>Bonjour <strong>{{ $reservation->user->firstName }} {{ $reservation->user->lastName }}</strong>,</p>
    
    <p>Nous tenons à vous rappeler que votre paiement pour la réservation suivante est en attente :</p>
    
    <div class="highlight info">
        <p><strong>Véhicule :</strong> {{ $vehicleName }}</p>
        <p><strong>Période de location :</strong> Du {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p><strong>Montant dû :</strong> {{ number_format($totalPrice, 2) }} €</p>
    </div>
    
    <p>Pour garantir votre réservation, veuillez procéder au paiement en cliquant sur le bouton ci-dessous :</p>
    
    <div style="text-align: center;">
        <a href="{{ $paymentLink }}" class="button">Procéder au paiement</a>
    </div>
    
    <p>Si vous avez déjà effectué le paiement, veuillez ignorer ce message.</p>
    
    <p>Pour toute question concernant votre réservation, n'hésitez pas à nous contacter.</p>
    
    <div class="footer">
        <p>Cordialement,<br>L'équipe de {{ $companyName }}</p>
        
        <p style="font-size: 0.85em; color: #6b7280;">
            Si vous rencontrez des difficultés avec le bouton, copiez et collez l'URL suivante dans votre navigateur : 
            <a href="{{ $paymentLink }}">{{ $paymentLink }}</a>
        </p>
    </div>
</body>
</html>
