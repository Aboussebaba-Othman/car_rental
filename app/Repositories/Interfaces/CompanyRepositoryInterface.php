<?php

namespace App\Repositories\Interfaces;

interface CompanyRepositoryInterface
{
    public function all();
    
    public function find($id);
    
    public function create(array $data);
    
    public function update($id, array $data);
    
    public function delete($id);
    
    public function findBy($column, $value);
    
    public function getAllCompanies();
    
    public function findByNameOrCity(string $search);
    
    public function getAllCities();
    
    public function getAllWithUsers();
    
    public function findWithUser($id);
    
    public function getPendingValidation();
}