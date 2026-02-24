<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleResource;
use App\Policies\AdminStorePolicy;
use App\Repositories\Contracts\SaleRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class SaleController extends Controller
{
    private SaleRepositoryInterface $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function index(int $storeId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
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
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
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
}