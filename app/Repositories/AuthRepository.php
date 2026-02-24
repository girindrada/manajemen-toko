<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Store_user;
use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

         $role = Role::where('name', 'super_admin')->first();

        Store_user::create([
            'store_id' => null,
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        return $user->load('storeUsers.role');
    }

    public function login(array $credentials){
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        return [
            'user' => auth()->guard('api')->user()->load('storeUsers'),
            'token' => $token,
        ];
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function updateProfile(int $userId, array $data)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'password' => isset($data['password']) ? bcrypt($data['password']) : $user->password,
        ]);

        return $user;
    }
}