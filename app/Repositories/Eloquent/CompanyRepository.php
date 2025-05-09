<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected $model;
    
    public function __construct(Company $model)
    {
        $this->model = $model;
    }
    
    
    public function all()
    {
        return $this->model->all();
    }
    
    public function find($id)
    {
        return $this->model->find($id);
    }
    
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
   
    public function update($id, array $data)
    {
        $company = $this->find($id);
        if ($company) {
            $company->update($data);
        }
        return $company;
    }
    
    public function delete($id)
    {
        $company = $this->find($id);
        if ($company) {
            return $company->delete();
        }
        return false;
    }
    
   
    public function findBy($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }
    
   
    public function getAllCompanies()
    {
        return $this->model->all();
    }
    
    
    public function findByNameOrCity(string $search)
    {
        return $this->model->where('company_name', 'LIKE', "%{$search}%")
            ->orWhere('city', 'LIKE', "%{$search}%")
            ->get();
    }
    
    
    public function getAllCities()
    {
        return $this->model->distinct('city')->pluck('city')->toArray();
    }
    
    
    public function getAllWithUsers()
    {
        return $this->model->with('users')->get();
    }
    
    
    public function findWithUser($id)
    {
        return $this->model->with('users')->find($id);
    }
    
    
    public function getPendingValidation()
    {
        return $this->model->where('status', 'pending')->get();
    }
}