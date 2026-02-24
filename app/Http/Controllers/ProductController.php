<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Policies\AdminStorePolicy;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(int $storeId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $products = $this->productRepository->getAllByStore($storeId);

        return response()->json([
            'message' => 'Success',
            'data' => ProductResource::collection($products),
        ]);
    }

    public function show(int $storeId, int $productId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $product = $this->productRepository->findByStore($storeId, $productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'message' => 'Success',
            'data' => new ProductResource($product),
        ]);
    }

    public function store(ProductRequest $request, int $storeId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $product = $this->productRepository->create($storeId, $request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ], 201);
    }

    public function update(ProductRequest $request, int $storeId, int $productId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $product = $this->productRepository->update($storeId, $productId, $request->validated());

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ]);
    }

    public function destroy(int $storeId, int $productId)
    {
        if (Gate::denies('manageStore', [AdminStorePolicy::class, $storeId])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $deleted = $this->productRepository->delete($storeId, $productId);

        if (!$deleted) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }
}