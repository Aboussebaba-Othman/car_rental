<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class DashboardController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        $company = $this->companyRepository->findWithUser(Auth::user()->company->id);

        $company->load([
            'vehicles.photos', 
            'vehicles.reservations.user',
            'reservations.vehicle',
            'reservations.user',
            'promotions'
        ]);

        return view('company.dashboard', compact('company'));
    }
}