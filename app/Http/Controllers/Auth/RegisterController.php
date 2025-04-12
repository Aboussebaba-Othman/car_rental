<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class RegisterController extends Controller
{
    protected $userRepository;
    protected $companyRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }

 
    public function showCompanyRegisterForm()
    {
        return view('auth.register-company');
    }

   
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|min:3|max:255',
            'lastName' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
            'required',
            'string',
            'min:8',
            'confirmed'
            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'phone' => [
            'nullable',
            'string',
            'max:20',
            // 'regex:/^(?:\+212|0)([6-7])\d{8}$/'
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

         $this->userRepository->create([
            'role_id' => Role::USER,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        // auth()->login($user);

        return redirect()->route('login')->with('success', 'Account registered successfully!');
    }

  
//     public function registerCompany(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'username' => 'required|string|max:255|unique:users',
//         'email' => 'required|string|email|max:255|unique:users',
//         'password' => 'required|string|min:8|confirmed',
//         'phone' => 'required|string|max:20',
//         'company_name' => 'required|string|max:255',
//         'address' => 'required|string|max:255',
//         'legal_documents' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
//     ]);

//     if ($validator->fails()) {
//         return redirect()->back()
//             ->withErrors($validator)
//             ->withInput();
//     }

//     $user = $this->userRepository->create([
//         'role_id' => Role::COMPANY,
//         'username' => $request->username,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//         'phone' => $request->phone,
//         'is_active' => true,
//     ]);

//     $legalDocumentsPath = null;
//     if ($request->hasFile('legal_documents')) {
//         $legalDocumentsPath = $request->file('legal_documents')->store('legal_documents', 'public');
//     }

//     $this->companyRepository->create([
//         'user_id' => $user->id,
//         'company_name' => $request->company_name,
//         'address' => $request->address,
//         'legal_documents' => $legalDocumentsPath,
//         'is_validated' => false,
//     ]);

//     return redirect()->route('login')
//         ->with('info', 'Your company account has been registered and is pending approval from our administrators.');
// }
public function registerCompany(Request $request)
{
    $validator = Validator::make($request->all(), [
        'firstName' => 'required|string|min:3|max:255',
        'lastName' => 'required|string|min:3|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed'
            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
        ],
        'phone' => [
            'nullable',
            'string',
            'max:20',
            // 'regex:/^(?:\+212|0)([6-7])\d{8}$/'
        ],
        'company_name' => 'required|string|min:3|max:255',
        'address' => 'required|string|min:10|max:255',
        'city' => 'required|string|max:255',
        'registre_commerce' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'carte_fiscale' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'cnas_casnos' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'autorisation_exploitation' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'contrat_location' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'assurance_entreprise' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Create user first
    $user = $this->userRepository->create([
        'role_id' => Role::COMPANY,
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'is_active' => true,
    ]);

    // Process and store each document
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

    // Create company profile with basic info and documents
    $this->companyRepository->create([
        'user_id' => $user->id,
        'company_name' => $request->company_name,
        'address' => $request->address,
        'city' => $request->city,
        'legal_documents' => json_encode($documents),
        'is_validated' => false,
    ]);

    // Redirect to login page
    return redirect()->route('login')
        ->with('success', 'Account registered successfully! Please login to continue.');

}
}