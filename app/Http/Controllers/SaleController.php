<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SaleResource;
use App\Policies\AdminStorePolicy;
use App\Policies\KasirStorePolicy;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\SaleRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class SaleController extends Controller
{
    private SaleRepositoryInterface $saleRepository;
    private ProductRepositoryInterface $productRepository;

    public function __construct(SaleRepositoryInterface $saleRepository, ProductRepositoryInterface $productRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->productRepository = $productRepository;
    }

    public function index(int $storeId)
    {
        // cek admin atau kasir
        $isAdmin = Gate::check('manageStore', [AdminStorePolicy::class, $storeId]);
        $isKasir = Gate::check('manageStore', [KasirStorePolicy::class, $storeId]);

        if (!$isAdmin && !$isKasir) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $sales = $this->saleRepository->getAllByStore($storeId);

        return response()->json([
            'message' => 'Success get all sales data',
            'data' => SaleResource::collection($sales),
        ]);
    }

    public function show(int $storeId, int $saleId)
    {
        // cek admin atau kasir
        $isAdmin = Gate::check('manageStore', [AdminStorePolicy::class, $storeId]);
        $isKasir = Gate::check('manageStore', [KasirStorePolicy::class, $storeId]);

        if (!$isAdmin && !$isKasir) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $sale = $this->saleRepository->findByStore($storeId, $saleId);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        return response()->json([
            'message' => 'Success get sale data by id',
            'data' => new SaleResource($sale),
        ]);
    }

    // kasir buat transaksi
    public function createSale(SaleRequest $request, int $storeId)
    {
        if (Gate::denies('manageStore', [KasirStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $sale = $this->saleRepository->createSale($storeId, $request->validated());

        return response()->json([
            'message' => 'Sale created successfully',
            'data' => new SaleResource($sale),
        ], 201);
    }
}