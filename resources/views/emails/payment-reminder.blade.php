@component('mail::message')
# Rappel de paiement pour votre réservation

Bonjour **{{ $reservation->user->name }}**,

Nous tenons à vous rappeler que votre paiement pour la réservation suivante est en attente :

**Véhicule :** {{ $vehicleName }}  
**Période de location :** Du {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}  
**Montant dû :** {{ number_format($totalPrice, 2) }} €

Pour garantir votre réservation, veuillez procéder au paiement en cliquant sur le bouton ci-dessous :

@component('mail::button', ['url' => $paymentLink, 'color' => 'blue'])
Procéder au paiement
@endcomponent

Si vous avez déjà effectué le paiement, veuillez ignorer ce message.

Pour toute question concernant votre réservation, n'hésitez pas à nous contacter.

Cordialement,  
L'équipe de {{ $companyName }}

@component('mail::subcopy')
Si vous rencontrez des difficultés avec le bouton, copiez et collez l'URL suivante dans votre navigateur : [{{ $paymentLink }}]({{ $paymentLink }})
@endcomponent
@endcomponent
