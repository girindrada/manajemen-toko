<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\AuthLoginResource;
use App\Http\Resources\AuthRegisterResource;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(AuthRegisterRequest $request)
    {
        $user = $this->authRepository->register($request->validated());
        
        return response()->json([
            'message' => 'Register success',
            'data' => new AuthRegisterResource($user),
        ], 201);
    }

    public function login(AuthLoginRequest $request)
    {
        $user = $this->authRepository->login($request->validated());

        return response()->json([
            'message' => 'Login success',
            'data' => [
                'user' => new AuthLoginResource($user['user']),
                'token' => $user['token'],
                'token_type' => 'bearer'
            ],
        ]);
    }

    public function logout()
    {
        $this->authRepository->logout();

        return response()->json([
            'message' => 'logout success',
        ], 200);
    }
}
