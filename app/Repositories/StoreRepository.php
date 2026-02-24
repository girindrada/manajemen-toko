<?php

namespace App\Repositories;

use App\Models\Store;
use App\Models\User;
use App\Models\Store_user;
use App\Models\Role;
use App\Repositories\Contracts\StoreRepositoryInterface;

class StoreRepository implements StoreRepositoryInterface
{
    public function getAll()
    {
        return Store::with(['level', 'users'])->get();
    }

    public function findById(int $id)
    {
        return Store::with(['level', 'users'])->find($id);
    }

    public function create(array $data)
    {
        $store = Store::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'store_level_id' => $data['store_level_id'],
        ]);

        // 2. Auto generate admin & kasir
        $this->generateStoreUsers($store);

        return $store->load(['level', 'users']);
    }

    public function update(int $id, array $data)
    {
        $store = $this->findById($id);

        $store->update($data);

        return $store->load(['level', 'users']);
    }

    public function delete(int $id)
    {
        $store = $this->findById($id);

        $store->delete();
    }

    private function generateStoreUsers(Store $store)
    {
        $roles = ['admin', 'kasir'];

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();

            // generate kredensial
            $slug = rand(1000, 9999);
            $password = config('app.default_password_store_user');

            $user = User::create([
                'name' => $roleName . ' ' . $store->name,
                'email' => $roleName . '.' . $slug . '@gmail.com',
                'password' => bcrypt($password),
            ]);

            Store_user::create([
                'store_id' => $store->id,
                'user_id' => $user->id,
                'role_id' => $role->id,
            ]);
        }
    }
}