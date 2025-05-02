<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Company;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'vehicle.company']);
        
        if ($request->filled('status')) {
            $status = $request->status;
            
            if ($status === 'cancelled' || $status === 'canceled') {
                $query->where(function($q) {
                    $q->where('status', 'canceled')
                      ->orWhere('status', 'cancelled');
                });
            } else {
                $query->where('status', $status);
            }
        }
        
        if ($request->filled('company_id')) {
            $query->whereHas('vehicle', function($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }
        
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                
                $q->orWhereHas('user', function($uq) use ($search) {
                    $uq->where('firstName', 'like', "%{$search}%")
                       ->orWhere('lastName', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('vehicle', function($vq) use ($search) {
                    $vq->where('brand', 'like', "%{$search}%")
                       ->orWhere('model', 'like', "%{$search}%")
                       ->orWhere('license_plate', 'like', "%{$search}%");
                });
            });
        }
        
        $reservations = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $companies = Company::select('id', 'company_name')->get();
        
        
        $paymentPendingCount = Reservation::where('status', 'payment_pending')->count();
        
        $pendingCount = Reservation::where('status', 'pending')->count();
        
        $confirmedCount = Reservation::where('status', 'confirmed')->count();
        
        $cancelledCount = Reservation::where(function($query) {
            $query->where('status', 'canceled')
                  ->orWhere('status', 'cancelled');
        })->count();
        
        return view('admin.reservations.index', compact(
            'reservations', 
            'companies', 
            'paymentPendingCount', 
            'pendingCount', 
            'confirmedCount', 
            'cancelledCount'
        ));
    }

    
    public function show($id)
    {
        $reservation = Reservation::with([
            'user', 
            'vehicle.company', 
            'vehicle.photos', 
            'promotion'
        ])->findOrFail($id);
        
        return view('admin.reservations.show', compact('reservation'));
    }
}
