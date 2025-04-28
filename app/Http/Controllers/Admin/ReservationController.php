<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\Company;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations with filtering capabilities.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Build query with relationships
        $query = Reservation::with(['user', 'vehicle.company']);
        
        // Apply status filter
        if ($request->filled('status')) {
            $status = $request->status;
            
            // Handle both 'canceled' and 'cancelled' spelling variants
            if ($status === 'cancelled' || $status === 'canceled') {
                $query->where(function($q) {
                    $q->where('status', 'canceled')
                      ->orWhere('status', 'cancelled');
                });
            } else {
                $query->where('status', $status);
            }
        }
        
        // Apply company filter
        if ($request->filled('company_id')) {
            $query->whereHas('vehicle', function($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }
        
        // Apply date range filters
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Search by ID
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                
                // Search by user name or email
                $q->orWhereHas('user', function($uq) use ($search) {
                    $uq->where('firstName', 'like', "%{$search}%")
                       ->orWhere('lastName', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                // Search by vehicle information
                ->orWhereHas('vehicle', function($vq) use ($search) {
                    $vq->where('brand', 'like', "%{$search}%")
                       ->orWhere('model', 'like', "%{$search}%")
                       ->orWhere('license_plate', 'like', "%{$search}%");
                });
            });
        }
        
        // Get paginated results
        $reservations = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get companies for filter dropdown
        $companies = Company::select('id', 'company_name')->get();
        
        // Calculate statistics
        
        // Payment pending reservations
        $paymentPendingCount = Reservation::where('status', 'payment_pending')->count();
        
        // Pending reservations
        $pendingCount = Reservation::where('status', 'pending')->count();
        
        // Confirmed reservations
        $confirmedCount = Reservation::where('status', 'confirmed')->count();
        
        // Canceled/Cancelled reservations - handle both spelling variants
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

    /**
     * Display the specified reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
