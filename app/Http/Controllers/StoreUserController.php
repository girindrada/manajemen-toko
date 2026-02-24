<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\StoreUserResource;
use App\Repositories\Contracts\StoreUserRepositoryInterface;

class StoreUserController extends Controller
{
    private StoreUserRepositoryInterface $storeUserRepository;

    public function __construct(StoreUserRepositoryInterface $storeUserRepository)
    {
        $this->storeUserRepository = $storeUserRepository;
    }

    public function index(int $storeId)
    {
        $users = $this->storeUserRepository->getAllByStore($storeId);

        if (!$users) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        return response()->json([
            'message' => 'Success',
            'data' => StoreUserResource::collection($users),
        ]);
    }

    public function show(int $storeId, int $userId)
    {
        $user = $this->storeUserRepository->findByStore($storeId, $userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'message' => 'Success',
            'data' => new StoreUserResource($user),
        ]);
    }

    public function update(StoreUserRequest $request, int $storeId, int $userId)
    {
        $user = $this->storeUserRepository->update($storeId, $userId, $request->validated());

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'message' => 'User updated successfully',
            'data' => new StoreUserResource($user),
        ]);
    }

    public function destroy(int $storeId, int $userId)
    {
        $deleted = $this->storeUserRepository->delete($storeId, $userId);

        if (!$deleted) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}