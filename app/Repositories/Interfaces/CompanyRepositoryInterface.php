<?php

namespace App\Repositories\Interfaces;

interface CompanyRepositoryInterface extends RepositoryInterface
{
    public function findByUserId(int $userId);
    public function getPendingValidation();
}