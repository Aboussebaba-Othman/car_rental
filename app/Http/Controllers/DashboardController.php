<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // For regular users, show their reservations
        if ($user->isUser()) {
            $now = Carbon::now();
            
            $currentReservations = $user->reservations()
                ->where(function($query) use ($now) {
                    $query->where('end_date', '>=', $now)
                          ->orWhere('status', 'confirmed');
                })
                ->orderBy('start_date')
                ->get();
                
            $pastReservations = $user->reservations()
                ->where('end_date', '<', $now)
                ->where('status', 'completed')
                ->orderByDesc('end_date')
                ->get();
                
            return view('dashboard.user.index', compact('currentReservations', 'pastReservations'));
        }
        
       
    }
}
