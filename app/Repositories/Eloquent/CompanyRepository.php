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
    
    /**
     * Get all resources
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }
    
    /**
     * Find resource by id
     *
     * @param int $id
     * @return \App\Models\Company|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
    
    /**
     * Create a new resource
     *
     * @param array $data
     * @return \App\Models\Company
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    /**
     * Update the resource
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Company
     */
    public function update($id, array $data)
    {
        $company = $this->find($id);
        if ($company) {
            $company->update($data);
        }
        return $company;
    }
    
    /**
     * Delete the resource
     *
     * @param int $id
     * @return bool
     */
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
    
    /**
     * Find companies by name or city
     * 
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByNameOrCity(string $search)
    {
        return $this->model->where('company_name', 'LIKE', "%{$search}%")
            ->orWhere('city', 'LIKE', "%{$search}%")
            ->get();
    }
    
    /**
     * Get all cities where companies are located
     * 
     * @return array
     */
    public function getAllCities()
    {
        return $this->model->distinct('city')->pluck('city')->toArray();
    }
    
    /**
     * Get all companies with their users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithUsers()
    {
        return $this->model->with('users')->get();
    }
    
    /**
     * Find company with its users
     *
     * @param int $id
     * @return \App\Models\Company|null
     */
    public function findWithUser($id)
    {
        return $this->model->with('users')->find($id);
    }
    
    /**
     * Get companies pending validation
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingValidation()
    {
        return $this->model->where('status', 'pending')->get();
    }
}