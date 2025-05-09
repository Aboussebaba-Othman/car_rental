<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegistrationController extends Controller
{
    protected $companyRepository;
    
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    
    
    public function showCompleteRegistration()
    {
        return view('company.complete-registration');
    }
    
    public function completeRegistration(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'registre_commerce' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'carte_fiscale' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'cnas_casnos' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'autorisation_exploitation' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'contrat_location' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'assurance_entreprise' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);
        
        $user = Auth::user();
        User::where('id', $user->id)->update([
            'phone' => $request->phone
        ]);
        
        $documents = [];
        $documentFields = [
            'registre_commerce', 
            'carte_fiscale', 
            'cnas_casnos', 
            'autorisation_exploitation', 
            'contrat_location', 
            'assurance_entreprise'
        ];
        
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('company_documents/' . $user->id, 'public');
                $documents[$field] = $path;
            }
        }
        
        $this->companyRepository->create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'city' => $request->city,
            'legal_documents' => json_encode($documents),
            'is_validated' => false,
        ]);
        
        return redirect()->route('company.dashboard')
            ->with('info', 'Your company account has been registered and is pending approval from our administrators.');
    }
}
