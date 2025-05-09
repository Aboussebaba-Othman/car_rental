<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Reservation $reservation)
    {
        // Check if the reservation belongs to the authenticated user
        if ($reservation->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to review this reservation.');
        }

        // Check if reservation is completed
        if ($reservation->status !== 'completed') {
            return redirect()->back()->with('error', 'You can only review completed reservations.');
        }

        // Check if reservation already has a review
        if ($reservation->review) {
            return redirect()->route('reviews.edit', $reservation->review)->with('info', 'You have already reviewed this reservation.');
        }
        
        return view('reviews.create', compact('reservation'));
    }
    
    public function store(Request $request, Reservation $reservation)
    {
        // Validate request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        // Check if the reservation belongs to the authenticated user
        if ($reservation->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to review this reservation.');
        }
        
        // Create review
        $review = new Review([
            'user_id' => auth()->id(),
            'vehicle_id' => $reservation->vehicle_id,
            'reservation_id' => $reservation->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Reviews require approval by default
        ]);
        
        $review->save();
        
        return redirect()->route('user.reservations')->with('success', 'Your review has been submitted and is pending approval.');
    }
    
    public function edit(Review $review)
    {
        // Check if the review belongs to the authenticated user
        if ($review->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to edit this review.');
        }
        
        $reservation = $review->reservation;
        return view('reviews.edit', compact('review', 'reservation'));
    }
    
    public function update(Request $request, Review $review)
    {
        // Validate request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        // Check if the review belongs to the authenticated user
        if ($review->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to edit this review.');
        }
        
        // Update review - reset approval since content has changed
        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false,
        ]);
        
        return redirect()->route('user.reservations')->with('success', 'Your review has been updated and is pending approval.');
    }
}
