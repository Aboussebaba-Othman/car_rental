<?php

namespace App\Repositories\Interfaces;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReservationRepositoryInterface
{
    /**
     * Get filtered reservations with pagination
     *
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFilteredReservations(Request $request, int $perPage = 10): LengthAwarePaginator;
    
    /**
     * Get reservation statistics
     *
     * @param int|null $companyId
     * @return array
     */
    public function getReservationStats(?int $companyId = null): array;
    
    /**
     * Get previous reservations for a user
     *
     * @param int $userId
     * @param int $excludeReservationId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPreviousReservations(int $userId, int $excludeReservationId, int $limit = 3);
    
    /**
     * Confirm a reservation
     *
     * @param Reservation $reservation
     * @param int $confirmedBy
     * @return Reservation
     */
    public function confirmReservation(Reservation $reservation, int $confirmedBy): Reservation;
    
    /**
     * Cancel a reservation
     *
     * @param Reservation $reservation
     * @param int $canceledBy
     * @param string|null $reason
     * @return Reservation
     */
    public function cancelReservation(Reservation $reservation, int $canceledBy, ?string $reason = null): Reservation;
    
    /**
     * Complete a reservation
     *
     * @param Reservation $reservation
     * @param int $completedBy
     * @return Reservation
     */
    public function completeReservation(Reservation $reservation, int $completedBy): Reservation;
    
    /**
     * Mark a reservation as paid
     *
     * @param Reservation $reservation
     * @return Reservation
     */
    public function markReservationAsPaid(Reservation $reservation): Reservation;
    
    /**
     * Check if a reservation belongs to a company
     *
     * @param Reservation $reservation
     * @param int $companyId
     * @return bool
     */
    public function reservationBelongsToCompany(Reservation $reservation, int $companyId): bool;
    
    /**
     * Authorize a vehicle belongs to user's company
     *
     * @param \App\Models\Vehicle $vehicle
     * @return bool
     */
    public function authorizeVehicle($vehicle): bool;
}
