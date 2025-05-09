<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyManagementController extends Controller 
{
    protected $companyRepository;
    protected $userRepository;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $companies = $this->companyRepository->getAllWithUsers();
        
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        
        $companiesPaginator = new LengthAwarePaginator(
            $companies->forPage($currentPage, $perPage),
            $companies->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
        
        return view('admin.companies.index', compact('companiesPaginator'));
    }

    public function show($id)
    {
        $company = $this->companyRepository->findWithUser($id);
        return view('admin.companies.show', compact('company'));
    }

    public function validate($id)
    {
        $company = $this->companyRepository->find($id);
        $this->companyRepository->update($id, ['is_validated' => true]);

        return redirect()->route('admin.companies.index')
            ->with('success', "L'entreprise '{$company->company_name}' a été validée avec succès.");
    }

    public function suspend($id)
    {
        $company = $this->companyRepository->findWithUser($id);
        $this->userRepository->update($company->user->id, ['is_active' => false]);

        return redirect()->route('admin.companies.index')
            ->with('success', "L'entreprise '{$company->company_name}' a été suspendue.");
    }

    public function reactivate($id)
    {
        $company = $this->companyRepository->findWithUser($id);
        $this->userRepository->update($company->user->id, ['is_active' => true]);

        return redirect()->route('admin.companies.index')
            ->with('success', "L'entreprise '{$company->company_name}' a été réactivée.");
    }
    
}