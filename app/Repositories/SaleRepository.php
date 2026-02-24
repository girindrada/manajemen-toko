<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\Contracts\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAllByStore(int $storeId)
    {
        return Sale::with(['user'])
            ->where('store_id', $storeId)
            ->get();
    }

    public function findByStore(int $storeId, int $saleId)
    {
        return Sale::with(['user', 'details.product'])
            ->where('store_id', $storeId)
            ->where('id', $saleId)
            ->first();
    }
}