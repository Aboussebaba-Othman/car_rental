<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Models\Message;
use App\Models\Review;

class DashboardController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        // Get the authenticated user's company with related entities
        $company = $this->companyRepository->findWithUser(Auth::user()->company->id);

        // Load the vehicles, reservations, and other related data
        $company->load([
            'vehicles.photos', 
            'vehicles.reservations.user',
            'reservations.vehicle',
            'reservations.user',
            'promotions'
        ]);

        // Get recent messages (placeholder for now, update with your message model)
        $messages = Message::where('company_id', $company->id)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

        // Get recent reviews (placeholder for now, update with your review model)
        $reviews = Review::whereHas('vehicle', function($query) use ($company) {
                        $query->where('company_id', $company->id);
                    })
                    ->with(['user', 'vehicle'])
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

        return view('company.dashboard', compact('company', 'messages', 'reviews'));
    }
}