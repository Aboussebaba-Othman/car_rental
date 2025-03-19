<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    public function getAllWithUsers()
    {
        return $this->model->with('user')->latest()->paginate(10);
    }

    public function findWithUser($id)
    {
        return $this->model->with('user')->findOrFail($id);
    }

    public function getPendingValidation()
    {
        return $this->model->where('is_validated', false)
            ->with('user')
            ->latest()
            ->get();
    }
}