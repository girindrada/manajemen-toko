<?php

namespace App\Repositories\Contracts;

interface StoreUserRepositoryInterface
{
    public function getAllByStore(int $storeId);

    public function findByStore(int $storeId, int $userId);

    public function update(int $storeId, int $userId, array $data);
    
    public function delete(int $storeId, int $userId);
}