<?php

namespace App\Repositories\Interfaces;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReservationRepositoryInterface
{
    public function getFilteredReservations(Request $request, int $perPage = 10): LengthAwarePaginator;
   
    public function getReservationStats(?int $companyId = null): array;
    
    public function getPreviousReservations(int $userId, int $excludeReservationId, int $limit = 3);
  
    public function confirmReservation(Reservation $reservation, int $confirmedBy): Reservation;
   
    public function cancelReservation(Reservation $reservation, int $canceledBy, ?string $reason = null): Reservation;
    
    public function completeReservation(Reservation $reservation, int $completedBy): Reservation;
  
    public function markReservationAsPaid(Reservation $reservation): Reservation;
    
    public function reservationBelongsToCompany(Reservation $reservation, int $companyId): bool;
    
    public function authorizeVehicle($vehicle): bool;
}
