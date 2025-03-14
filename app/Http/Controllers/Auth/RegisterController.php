<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

         $this->userRepository->create([
            'role_id' => Role::USER,
            'username' => $request->username,
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
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'phone' => 'required|string|max:20',
        'company_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Create user first
    $user = $this->userRepository->create([
        'role_id' => Role::COMPANY,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'is_active' => true,
    ]);

    // Create company profile with basic info
    $this->companyRepository->create([
        'user_id' => $user->id,
        'company_name' => $request->company_name,
        'address' => $request->address,
        'is_validated' => false,
    ]);

    // Log the user in
    // Auth::login($user);

    // Redirect to document upload page
    return redirect()->route('company.documents.upload')
        ->with('success', 'Basic registration completed. Please upload your required documents.');
}
}