<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Request;

class LocationSearchController extends Controller
{
    private $companyRepository;
    
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function search(Request $request)
    {
        $search = $request->input('query');
        
        if (empty($search) || strlen($search) < 2) {
            return response()->json([]);
        }
        
        $companies = $this->companyRepository->findByNameOrCity($search);
        
        $suggestions = [];
        
        foreach ($companies as $company) {
        
            $suggestions[] = [
                'value' => $company->name,
                'label' => $company->name,
                'type' => 'company',
                'address' => $company->address,
                'city' => $company->city
            ];
            
            if (!in_array($company->city, array_column($suggestions, 'value'))) {
                $suggestions[] = [
                    'value' => $company->city,
                    'label' => $company->city,
                    'type' => 'city'
                ];
            }
        }
        
        return response()->json($suggestions);
    }
}
