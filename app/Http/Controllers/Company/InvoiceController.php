<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

class InvoiceController extends Controller
{
    public function download($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        if ($reservation->vehicle->company_id != AUTH::user()->company->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $company = AUTH::user()->company;
        
        $pdf = PDF::loadView('company.invoices.pdf', [
            'reservation' => $reservation,
            'company' => $company
        ]);
        
        return $pdf->download('facture-' . $reservation->id . '.pdf');
    }
}