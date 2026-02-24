<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Store_user;
use App\Models\User;
use App\Repositories\Contracts\CashierRepositoryInterface;

class CashierRepository implements CashierRepositoryInterface
{
    public function getAllByStore(int $storeId)
    {
        return Store_user::with(['user', 'role'])
            ->where('store_id', $storeId)
            ->whereHas('role', fn($q) => $q->where('name', 'kasir'))
            ->get();
    }

    public function findByStore(int $storeId, int $userId)
    {
        return Store_user::with(['user', 'role'])
            ->where('store_id', $storeId)
            ->where('user_id', $userId)
            ->whereHas('role', fn($q) => $q->where('name', 'kasir'))
            ->first();
    }

    public function create(int $storeId, array $data)
    {
        $role = Role::where('name', 'kasir')->first();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $storeUser = Store_user::create([
            'store_id' => $storeId,
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        return $storeUser->load(['user', 'role']);
    }

    public function update(int $storeId, int $userId, array $data)
    {
        $storeUser = Store_user::with(['user', 'role'])
            ->where('store_id', $storeId)
            ->where('user_id', $userId)
            ->whereHas('role', fn($q) => $q->where('name', 'kasir'))
            ->first();

        if (!$storeUser) {
            return null;
        }

        $storeUser->user->update([
            'name' => $data['name'] ?? $storeUser->user->name,
            'email' => $data['email'] ?? $storeUser->user->email,
            'password' => isset($data['password']) ? bcrypt($data['password']) : $storeUser->user->password,
        ]);

        return $storeUser->load(['user', 'role']);
    }

    public function delete(int $storeId, int $userId)
    {
        $storeUser = Store_user::where('store_id', $storeId)
            ->where('user_id', $userId)
            ->whereHas('role', fn($q) => $q->where('name', 'kasir'))
            ->first();

        if (!$storeUser) {
            return false;
        }

        User::find($userId)->delete();
        $storeUser->delete();

        return true;
    }
}