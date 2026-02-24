<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllByStore(int $storeId, ?string $search = null, int $perPage = 10)
    {
        return Product::where('store_id', $storeId)
            ->when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->paginate($perPage);
    }

    public function findByStore(int $storeId, int $productId)
    {
        return Product::where('store_id', $storeId)
            ->where('id', $productId)
            ->first();
    }

    public function create(int $storeId, array $data)
    {
        return Product::create([
            'store_id' => $storeId,
            'name' => $data['name'],
            'price' => $data['price'],
        ]);
    }

    public function update(int $storeId, int $productId, array $data)
    {
        $product = Product::where('store_id', $storeId)
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return null;
        }

        $product->update($data);

        return $product;
    }

    public function delete(int $storeId, int $productId)
    {
        $product = Product::where('store_id', $storeId)
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return false;
        }

        $product->delete();

        return true;
    }
}