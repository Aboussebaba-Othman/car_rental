<?php

namespace App\Repositories\Interfaces;

interface CompanyRepositoryInterface
{
    /**
     * Get all resources
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();
    
    /**
     * Find resource by id
     *
     * @param int $id
     * @return \App\Models\Company|null
     */
    public function find($id);
    
    /**
     * Create a new resource
     *
     * @param array $data
     * @return \App\Models\Company
     */
    public function create(array $data);
    
    /**
     * Update the resource
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Company
     */
    public function update($id, array $data);
    
    /**
     * Delete the resource
     *
     * @param int $id
     * @return bool
     */
    public function delete($id);
    
    /**
     * Find resource by specific column
     *
     * @param string $column
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findBy($column, $value);
    
    /**
     * Get all companies
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCompanies();
    
    /**
     * Find companies by name or city
     * 
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByNameOrCity(string $search);
    
    /**
     * Get all cities where companies are located
     * 
     * @return array
     */
    public function getAllCities();
    
    /**
     * Get all companies with their users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithUsers();
    
    /**
     * Find company with its users
     *
     * @param int $id
     * @return \App\Models\Company|null
     */
    public function findWithUser($id);
    
    /**
     * Get companies pending validation
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingValidation();
}