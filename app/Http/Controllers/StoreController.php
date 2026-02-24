<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResource;
use App\Repositories\Contracts\StoreRepositoryInterface;

class StoreController extends Controller
{
    private StoreRepositoryInterface $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function index()
    {
        $stores = $this->storeRepository->getAll();

        return response()->json([
            'message' => 'Get all Store success',
            'data' => StoreResource::collection($stores), // pakai ::collection bukan new, untuk index() yg bukan single object
        ]);
    }

    public function show(int $id)
    {
        $store = $this->storeRepository->findById($id);

        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        return response()->json([
            'message' => 'Show Store by id success',
            'data' => new StoreResource($store),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $store = $this->storeRepository->create($request->validated());

        return response()->json([
            'message' => 'Store created successfully',
            'data' => new StoreResource($store),
        ], 201);
    }

    public function update(StoreRequest $request, int $id)
    {
        $store = $this->storeRepository->update($id, $request->validated());

        return response()->json([
            'message' => 'Store updated successfully',
            'data' => new StoreResource($store),
        ]);
    }

    public function destroy(int $id)
    {
        $this->storeRepository->delete($id);

        return response()->json([
            'message' => 'Store deleted successfully',
        ]);
    }
}