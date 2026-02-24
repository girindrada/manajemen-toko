<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    // get all product pada sebuah toko by storeId
    public function getAllByStore(int $storeId, ?string $search = null, int $perPage = 10);

    // get product in store by productId
    public function findByStore(int $storeId, int $productId);

    public function create(int $storeId, array $data);

    public function update(int $storeId, int $productId, array $data);

    public function delete(int $storeId, int $productId);
}