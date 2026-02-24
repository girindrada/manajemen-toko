<?php

namespace App\Repositories;

use App\Models\Store;
use App\Models\Store_user;
use App\Models\User;
use App\Repositories\Contracts\StoreUserRepositoryInterface;

class StoreUserRepository implements StoreUserRepositoryInterface
{
    public function getAllByStore(int $storeId)
    {
        $store = Store::find($storeId);

        if (!$store) {
            return null;
        }

        return Store_user::with(['user', 'role'])
            ->where('store_id', $storeId)
            ->get();
    }

    public function findByStore(int $storeId, int $userId)
    {
        return Store_user::with(['user', 'role'])
            ->where('store_id', $storeId)
            ->where('user_id', $userId)
            ->first();
    }

    public function update(int $storeId, int $userId, array $data)
    {
        $storeUser = Store_user::where('store_id', $storeId)
            ->where('user_id', $userId)
            ->first();

        if (!$storeUser) {
            return null;
        }

        // update data user
        $user = User::find($userId);
        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'password' => isset($data['password']) ? bcrypt($data['password']) : $user->password,
        ]);

        return $storeUser->load(['user', 'role']);
    }

    public function delete(int $storeId, int $userId)
    {
        $storeUser = Store_user::where('store_id', $storeId)
            ->where('user_id', $userId)
            ->first();

        if (!$storeUser) {
            return false;
        }

        // hapus user dan store_user 
        User::find($userId)->delete();
        $storeUser->delete();

        return true;
    }
}