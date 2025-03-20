<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
    public function getAllWithFilters(array $filters = [])
    {
        $query = $this->model->query();
        
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }
        
        if (isset($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }
        
        return $query->with('role')
            ->latest()
            ->paginate(10);
    }

    public function findWithDetails($id)
    {
        return $this->model->with(['role', 'company'])
            ->findOrFail($id);
    }

    public function searchUsers($search, array $filters = [])
    {
        $query = $this->model->query();
        
        $query->where(function($q) use ($search) {
            $q->where('firstName', 'like', "%{$search}%")
              ->orWhere('lastName', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
        
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }
        
        if (isset($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }
        
        return $query->with('role')
            ->latest()
            ->paginate(10);
    }
}