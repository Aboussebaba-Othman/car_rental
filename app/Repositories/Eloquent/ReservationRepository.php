<?php

namespace App\Repositories\Eloquent;

use App\Models\Reservation;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ReservationRepository implements ReservationRepositoryInterface
{
    protected $model;
    
    public function __construct(Reservation $reservation)
    {
        $this->model = $reservation;
    }
    

    public function getFilteredReservations(Request $request, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->query()
            ->with(['vehicle', 'user', 'promotion']);
        
        // Always filter by company if user has a company
        if (Auth::user() && Auth::user()->company) {
            $query->whereHas('vehicle', function ($query) {
                $query->where('company_id', Auth::user()->company->id);
            });
        }
        
        $query->latest();
        
        // Rest of the existing filters...
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->where('start_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->where('end_date', '<=', $request->date_to);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        return $query->paginate($perPage);
    }
    
    public function getReservationStats(?int $companyId = null): array
    {
        $query = $this->model->query();
        
        // If no company ID is provided but user has a company, use their company ID
        if ($companyId === null && Auth::user() && Auth::user()->company) {
            $companyId = Auth::user()->company->id;
        }
        
        // Filter by company if company ID is available
        if ($companyId !== null) {
            $query->whereHas('vehicle', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }
        
        return [
            'total' => (clone $query)->count(),
            'confirmed' => (clone $query)->where('status', 'confirmed')->count(),
            'pending' => (clone $query)->whereIn('status', ['pending', 'payment_pending'])->count(),
            'revenue' => (clone $query)->whereIn('status', ['confirmed', 'paid', 'completed'])
                           ->sum('total_price'),
        ];
    }
    
    public function getPreviousReservations(int $userId, int $excludeReservationId, int $limit = 3)
    {
        return $this->model->where('user_id', $userId)
            ->where('id', '!=', $excludeReservationId)
            ->latest()
            ->take($limit)
            ->get();
    }
    

    public function confirmReservation(Reservation $reservation, int $confirmedBy): Reservation
    {
        $reservation->status = 'confirmed';
        $reservation->confirmed_at = Carbon::now();
        $reservation->confirmed_by = $confirmedBy;
        $reservation->save();
        
        return $reservation;
    }
    
   
    public function cancelReservation(Reservation $reservation, int $canceledBy, ?string $reason = null): Reservation
    {
        $reservation->status = 'canceled';
        $reservation->canceled_at = Carbon::now();
        $reservation->canceled_by = $canceledBy;
        
        if ($reason) {
            $reservation->cancellation_reason = $reason;
        }
        
        $reservation->save();
        
        return $reservation;
    }

    public function completeReservation(Reservation $reservation, int $completedBy): Reservation
    {
        $reservation->status = 'completed';
        $reservation->completed_at = Carbon::now();
        $reservation->completed_by = $completedBy;
        $reservation->save();
        
        return $reservation;
    }

    public function markReservationAsPaid(Reservation $reservation): Reservation
    {
        $reservation->status = 'paid';
        $reservation->payment_method = 'manual';
        $reservation->payment_status = 'COMPLETED';
        $reservation->payment_date = Carbon::now();
        $reservation->amount_paid = $reservation->total_price;
        $reservation->transaction_id = 'MANUAL-' . strtoupper(substr(md5(uniqid()), 0, 10));
        $reservation->save();
        
        return $reservation;
    }

    public function reservationBelongsToCompany(Reservation $reservation, int $companyId): bool
    {
        // Make sure the vehicle relationship is loaded
        if (!$reservation->relationLoaded('vehicle')) {
            $reservation->load('vehicle');
        }
        
        // Handle null vehicle (shouldn't happen, but just to be safe)
        if (!$reservation->vehicle) {
            return false;
        }
        
        return $reservation->vehicle->company_id === $companyId;
    }
 
    public function authorizeVehicle($vehicle): bool
    {
        if (!$vehicle) {
            return false;
        }
        
        if (!Auth::user() || !Auth::user()->company) {
            return false;
        }
        
        return $vehicle->company_id === Auth::user()->company->id;
    }
}
