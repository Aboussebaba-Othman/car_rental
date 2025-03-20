<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email);
    public function searchUsers($search, array $filters = []);
    public function getAllWithFilters(array $filters = []);
    public function findWithDetails($id);
}