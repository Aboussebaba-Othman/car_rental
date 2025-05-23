<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $vehicleName;
    public $startDate;
    public $endDate;
    public $totalPrice;
    public $paymentLink;
    public $companyName;

    
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $this->vehicleName = $reservation->vehicle->brand . ' ' . $reservation->vehicle->model;
        $this->startDate = $reservation->start_date;
        $this->endDate = $reservation->end_date;
        $this->totalPrice = $reservation->total_price;
        $this->paymentLink = route('reservations.payment', $reservation->id);
        $this->companyName = $reservation->vehicle->company->company_name;
    }

   
    public function build()
    {
        return $this->subject('Rappel de paiement pour votre réservation')
                    ->markdown('emails.payment-reminder');
    }
}
