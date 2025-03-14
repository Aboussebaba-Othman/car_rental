<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null);
}