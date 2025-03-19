<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

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

    /**
     * Display a listing of companies.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $companies = $this->companyRepository->getAllWithUsers();
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show company details and documents.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $company = $this->companyRepository->findWithUser($id);
        return view('admin.companies.show', compact('company'));
    }

    /**
     * Validate a company account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validate($id)
    {
        $company = $this->companyRepository->find($id);
        $this->companyRepository->update($id, ['is_validated' => true]);

        return redirect()->route('admin.companies.index')
            ->with('success', "L'entreprise '{$company->company_name}' a été validée avec succès.");
    }

    /**
     * Suspend a company account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suspend($id)
    {
        $company = $this->companyRepository->findWithUser($id);
        $this->userRepository->update($company->user->id, ['is_active' => false]);

        return redirect()->route('admin.companies.index')
            ->with('success', "L'entreprise '{$company->company_name}' a été suspendue.");
    }

    /**
     * Reactivate a company account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reactivate($id)
    {
        $company = $this->companyRepository->findWithUser($id);
        $this->userRepository->update($company->user->id, ['is_active' => true]);

        return redirect()->route('admin.companies.index')
            ->with('success', "L'entreprise '{$company->company_name}' a été réactivée.");
    }
}