<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Repositories\Contracts\SaleRepositoryInterface;
use Illuminate\Support\Str;

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

    public function createSale(int $storeId, array $data)
    {
        // hitung total price
        $totalPrice = collect($data['items'])->sum(function ($item) {
            $product = Product::find($item['product_id']);
            return $product->price * $item['quantity'];
        });

        // buat sale
        $sale = Sale::create([
            'store_id' => $storeId,
            'user_id' => auth()->guard('api')->id(),
            'invoice' => 'INV-' . now()->format('Ymd'),
            'total_price' => $totalPrice,
        ]);

        // buat sale details
        foreach ($data['items'] as $item) {
            $product = Product::find($item['product_id']);

            Sale_detail::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $item['quantity'],
            ]);
        }

        return $sale->load(['user', 'details.product']);
    }
}