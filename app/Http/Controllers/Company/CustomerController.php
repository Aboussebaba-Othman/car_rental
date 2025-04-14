<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get customers who have made reservations with this company's vehicles
        $customersQuery = User::whereHas('reservations', function ($query) {
            $query->whereHas('vehicle', function ($vehicleQuery) {
                $vehicleQuery->where('company_id', Auth::user()->company_id);
            });
        })
        ->withCount(['reservations' => function ($query) {
            $query->whereHas('vehicle', function ($vehicleQuery) {
                $vehicleQuery->where('company_id', Auth::user()->company_id);
            });
        }])
        ->with(['reservations' => function ($query) {
            $query->whereHas('vehicle', function ($vehicleQuery) {
                $vehicleQuery->where('company_id', Auth::user()->company_id);
            });
            $query->latest()->limit(1);
        }]);
        
        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $customersQuery->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }
        
        // Get customers with pagination
        $customers = $customersQuery->orderBy('name')->paginate(15);
        
        // Get customer statistics for the current company
        $stats = [
            'total' => $customers->total(),
            'new_this_month' => User::whereHas('reservations', function ($query) {
                $query->whereHas('vehicle', function ($vehicleQuery) {
                    $vehicleQuery->where('company_id', Auth::user()->company_id);
                });
            })
            ->whereMonth('created_at', now()->month)
            ->count(),
            'repeat_customers' => DB::table('reservations')
                ->join('vehicles', 'reservations.vehicle_id', '=', 'vehicles.id')
                ->where('vehicles.company_id', Auth::user()->company_id)
                ->select('user_id')
                ->groupBy('user_id')
                ->havingRaw('COUNT(DISTINCT reservations.id) > 1')
                ->count(),
            'total_revenue' => Reservation::whereHas('vehicle', function ($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->whereIn('status', ['confirmed', 'paid', 'completed'])
            ->sum('total_price'),
        ];
        
        return view('company.customers.index', compact('customers', 'stats'));
    }

    /**
     * Display the specified customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = User::findOrFail($id);
        
        // Make sure this customer has made reservations with this company
        $hasReservations = Reservation::where('user_id', $id)
            ->whereHas('vehicle', function($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->exists();
        
        if (!$hasReservations) {
            abort(403, 'This customer does not have any reservations with your company.');
        }
        
        // Get reservations made by this customer with this company
        $reservations = Reservation::where('user_id', $id)
            ->whereHas('vehicle', function($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->with(['vehicle', 'promotion'])
            ->latest()
            ->get();
        
        // Calculate customer statistics
        $completedReservations = $reservations->whereIn('status', ['confirmed', 'paid', 'completed'])->count();
        $canceledReservations = $reservations->where('status', 'canceled')->count();
        $totalSpent = $reservations->whereIn('status', ['confirmed', 'paid', 'completed'])->sum('total_price');
        $averageReservationValue = $completedReservations > 0 ? $totalSpent / $completedReservations : 0;
        
        // Get favorite vehicles (most reserved by this customer)
        $favoriteVehicles = Vehicle::select('vehicles.*', DB::raw('COUNT(reservations.id) as reservation_count'))
            ->join('reservations', 'vehicles.id', '=', 'reservations.vehicle_id')
            ->where('reservations.user_id', $id)
            ->where('vehicles.company_id', Auth::user()->company_id)
            ->groupBy('vehicles.id')
            ->orderByDesc('reservation_count')
            ->limit(3)
            ->get();
        
        $customerStats = [
            'total_reservations' => $reservations->count(),
            'completed_reservations' => $completedReservations,
            'canceled_reservations' => $canceledReservations,
            'total_spent' => $totalSpent,
            'average_reservation_value' => $averageReservationValue,
            'first_reservation_date' => $reservations->last()->created_at ?? null,
            'last_reservation_date' => $reservations->first()->created_at ?? null,
        ];
        
        return view('company.customers.show', compact('customer', 'reservations', 'customerStats', 'favoriteVehicles'));
    }
    
    /**
     * Send a promotional email to the customer.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendPromotion($id, Request $request)
    {
        $customer = User::findOrFail($id);
        
        // Make sure this customer has made reservations with this company
        $hasReservations = Reservation::where('user_id', $id)
            ->whereHas('vehicle', function($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->exists();
        
        if (!$hasReservations) {
            abort(403, 'This customer does not have any reservations with your company.');
        }
        
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'promotion_id' => 'nullable|exists:promotions,id',
        ]);
        
        // In a real application, you would send an email here
        // Mail::to($customer->email)->send(new PromotionalEmail($request->subject, $request->message, $request->promotion_id));
        
        return redirect()->route('company.customers.show', $customer->id)
            ->with('success', 'Promotional email has been sent to ' . $customer->name);
    }
    
    /**
     * Generate a customer report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generateReport($id)
    {
        $customer = User::findOrFail($id);
        
        // Make sure this customer has made reservations with this company
        $hasReservations = Reservation::where('user_id', $id)
            ->whereHas('vehicle', function($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->exists();
        
        if (!$hasReservations) {
            abort(403, 'This customer does not have any reservations with your company.');
        }
        
        // Get reservations made by this customer with this company
        $reservations = Reservation::where('user_id', $id)
            ->whereHas('vehicle', function($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->with(['vehicle', 'promotion'])
            ->latest()
            ->get();
        
        // Calculate customer statistics (similar to show method)
        // ...
        
        // In a real application, you would generate a PDF report
        // $pdf = PDF::loadView('company.customers.report', compact('customer', 'reservations', 'customerStats'));
        // return $pdf->download('customer_' . $customer->id . '_report.pdf');
        
        return redirect()->route('company.customers.show', $customer->id)
            ->with('success', 'Customer report functionality would be implemented here.');
    }
}