<?php

namespace App\Repositories\Eloquent;

use App\Models\Reservation;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ReservationRepository implements ReservationRepositoryInterface
{
    protected $model;
    
    public function __construct(Reservation $reservation)
    {
        $this->model = $reservation;
    }
    
    /**
     * Get filtered reservations with pagination
     *
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFilteredReservations(Request $request, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->query()
            ->with(['vehicle', 'user', 'promotion'])
            ->latest();
        
        // Apply filters if any
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }
        
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        return $query->paginate($perPage)->appends($request->except('page'));
    }
    
    /**
     * Get reservation statistics
     *
     * @param int|null $companyId
     * @return array
     */
    public function getReservationStats(?int $companyId = null): array
    {
        $query = $this->model->query();
        
        return [
            'total' => (clone $query)->count(),
            'confirmed' => (clone $query)->where('status', 'confirmed')->count(),
            'pending' => (clone $query)->whereIn('status', ['pending', 'payment_pending'])->count(),
            'revenue' => (clone $query)->whereIn('status', ['confirmed', 'paid', 'completed'])
                           ->sum('total_price'),
        ];
    }
    
    /**
     * Get previous reservations for a user
     *
     * @param int $userId
     * @param int $excludeReservationId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPreviousReservations(int $userId, int $excludeReservationId, int $limit = 3)
    {
        return $this->model->where('user_id', $userId)
            ->where('id', '!=', $excludeReservationId)
            ->latest()
            ->take($limit)
            ->get();
    }
    
    /**
     * Confirm a reservation
     *
     * @param Reservation $reservation
     * @param int $confirmedBy
     * @return Reservation
     */
    public function confirmReservation(Reservation $reservation, int $confirmedBy): Reservation
    {
        $reservation->status = 'confirmed';
        
        // Vérifier si les colonnes existent avant de les mettre à jour
        if (Schema::hasColumn('reservations', 'confirmed_at')) {
            $reservation->confirmed_at = Carbon::now();
        }
        
        if (Schema::hasColumn('reservations', 'confirmed_by')) {
            $reservation->confirmed_by = $confirmedBy;
        }
        
        $reservation->save();
        
        return $reservation;
    }
    
    /**
     * Cancel a reservation
     *
     * @param Reservation $reservation
     * @param int $canceledBy
     * @param string|null $reason
     * @return Reservation
     */
    public function cancelReservation(Reservation $reservation, int $canceledBy, ?string $reason = null): Reservation
    {
        $reservation->status = 'canceled';
        
        // Vérifier si les colonnes existent avant de les mettre à jour
        // Si les colonnes n'existent pas, on ne les met pas à jour
        
        // Pour les colonnes cancelled_at et cancelled_by
        if (Schema::hasColumn('reservations', 'canceled_at')) {
            $reservation->canceled_at = Carbon::now();
        }
        
        if (Schema::hasColumn('reservations', 'canceled_by')) {
            $reservation->canceled_by = $canceledBy;
        }
        
        if ($reason && Schema::hasColumn('reservations', 'cancellation_reason')) {
            $reservation->cancellation_reason = $reason;
        }
        
        $reservation->save();
        
        return $reservation;
    }
    
    /**
     * Complete a reservation
     *
     * @param Reservation $reservation
     * @param int $completedBy
     * @return Reservation
     */
    public function completeReservation(Reservation $reservation, int $completedBy): Reservation
    {
        $reservation->status = 'completed';
        
        // Vérifier si les colonnes existent avant de les mettre à jour
        if (Schema::hasColumn('reservations', 'completed_at')) {
            $reservation->completed_at = Carbon::now();
        }
        
        if (Schema::hasColumn('reservations', 'completed_by')) {
            $reservation->completed_by = $completedBy;
        }
        
        $reservation->save();
        
        return $reservation;
    }
    
    /**
     * Mark a reservation as paid
     *
     * @param Reservation $reservation
     * @return Reservation
     */
    public function markReservationAsPaid(Reservation $reservation): Reservation
    {
        $reservation->status = 'paid';
        
        // S'assurer que ces colonnes existent dans la table
        if (Schema::hasColumn('reservations', 'payment_method')) {
            $reservation->payment_method = 'manual';
        }
        
        if (Schema::hasColumn('reservations', 'payment_status')) {
            $reservation->payment_status = 'COMPLETED';
        }
        
        if (Schema::hasColumn('reservations', 'payment_date')) {
            $reservation->payment_date = Carbon::now();
        }
        
        if (Schema::hasColumn('reservations', 'amount_paid')) {
            $reservation->amount_paid = $reservation->total_price;
        }
        
        if (Schema::hasColumn('reservations', 'transaction_id')) {
            $reservation->transaction_id = 'MANUAL-' . strtoupper(substr(md5(uniqid()), 0, 10));
        }
        
        $reservation->save();
        
        return $reservation;
    }
    
    /**
     * Check if a reservation belongs to a company
     *
     * @param Reservation $reservation
     * @param int $companyId
     * @return bool
     */
    public function reservationBelongsToCompany(Reservation $reservation, int $companyId): bool
    {
        return $reservation->vehicle->company_id === $companyId;
    }
}