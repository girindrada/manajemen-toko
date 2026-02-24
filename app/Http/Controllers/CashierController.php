<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashierRequest;
use App\Http\Resources\CashierResource;
use App\Policies\AdminStorePolicy;
use App\Repositories\Contracts\CashierRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CashierController extends Controller
{
    private CashierRepositoryInterface $cashierRepository;

    public function __construct(CashierRepositoryInterface $cashierRepository)
    {
        $this->cashierRepository = $cashierRepository;
    }

    public function index(int $storeId, Request $request)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $cashiers = $this->cashierRepository->getAllByStore($storeId,  $request->get('search'), $request->get('per_page', 5));

        return response()->json([
            'message' => 'Success get all cashier data',
            'data' => CashierResource::collection($cashiers->items()),
            'meta' => [
                'current_page' => $cashiers->currentPage(),
                'last_page' => $cashiers->lastPage(),
                'per_page' => $cashiers->perPage(),
                'total' => $cashiers->total(),
            ]
        ]);
    }

    public function show(int $storeId, int $userId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $cashier = $this->cashierRepository->findByStore($storeId, $userId);

        if (!$cashier) {
            return response()->json(['message' => 'Cashier not found'], 404);
        }

        return response()->json([
            'message' => 'Success get cashier data by id',
            'data' => new CashierResource($cashier),
        ]);
    }

    public function store(CashierRequest $request, int $storeId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $cashier = $this->cashierRepository->create($storeId, $request->validated());

        return response()->json([
            'message' => 'Cashier created successfully',
            'data' => new CashierResource($cashier),
        ], 201);
    }

    public function update(CashierRequest $request, int $storeId, int $userId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $cashier = $this->cashierRepository->update($storeId, $userId, $request->validated());

        if (!$cashier) {
            return response()->json(['message' => 'Cashier not found'], 404);
        }

        return response()->json([
            'message' => 'Cashier updated successfully',
            'data' => new CashierResource($cashier),
        ]);
    }

    public function destroy(int $storeId, int $userId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $deleted = $this->cashierRepository->delete($storeId, $userId);

        if (!$deleted) {
            return response()->json(['message' => 'Cashier not found'], 404);
        }

        return response()->json([
            'message' => 'Cashier deleted successfully',
        ]);
    }
}