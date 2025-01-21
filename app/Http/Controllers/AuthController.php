<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\User\JWTAuthContract;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private JWTAuthContract $authContract;

    public function __construct(JWTAuthContract $authContract)
    {
        $this->authContract = $authContract;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authContract->register($request->toDTO());

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => $user->toArray()
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $loginResult = $this->authContract->login($request->toDTO());

        if (!$loginResult->token) {
            return response()->json([
                'success' => false,
                'message' => $loginResult->message
            ], 401);
        }

        $cookie = cookie('jwt', $loginResult->token, 60);

        return response()->json([
            'success' => true,
            'message' => $loginResult->message,
            'token' => $loginResult->token,
        ])->withCookie($cookie);
    }

    public function user(): JsonResponse
    {
        $userResult = $this->authContract->getUser();

        if (!$userResult->isSuccess) {
            return response()->json([
                'message' => $userResult->message
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => $userResult->user,
        ]);
    }

    public function logout(): JsonResponse
    {
        $this->authContract->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
