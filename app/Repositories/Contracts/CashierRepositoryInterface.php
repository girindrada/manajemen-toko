<?php

namespace App\Repositories\Contracts;

interface CashierRepositoryInterface
{
    // get data all kasir berdasarkan store id
    public function getAllByStore(int $storeId);

    // get data kasir di store by id
    public function findByStore(int $storeId, int $userId);

    public function create(int $storeId, array $data);

    public function update(int $storeId, int $userId, array $data);

    public function delete(int $storeId, int $userId);
}