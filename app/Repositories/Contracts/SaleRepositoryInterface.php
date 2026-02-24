<?php

namespace App\Repositories\Contracts;

interface SaleRepositoryInterface
{
    public function getAllByStore(int $storeId);
    
    public function findByStore(int $storeId, int $saleId);
}