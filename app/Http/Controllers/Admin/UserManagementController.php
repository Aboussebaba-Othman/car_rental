<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = [];
        
        if ($request->filled('status')) {
            $filters['is_active'] = $request->status === 'active';
        }
        
        if ($request->filled('role')) {
            $filters['role_id'] = $request->role;
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $users = $this->userRepository->searchUsers($search, $filters);
        } else {
            $users = $this->userRepository->getAllWithFilters($filters);
        }
        
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithDetails($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Activate a user account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate($id)
    {
        $user = $this->userRepository->find($id);
        $this->userRepository->update($id, ['is_active' => true]);

        return redirect()->route('admin.users.index')
            ->with('success', "Le compte de {$user->firstName} {$user->lastName} a été activé avec succès.");
    }

    /**
     * Deactivate a user account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate($id)
    {
        $user = $this->userRepository->find($id);
        $this->userRepository->update($id, ['is_active' => false]);

        return redirect()->route('admin.users.index')
            ->with('success', "Le compte de {$user->firstName} {$user->lastName} a été désactivé avec succès.");
    }
}