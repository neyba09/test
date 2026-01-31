<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $data = $request->validated();
        $token = $this->authService->login($data['email'], $data['password']);

        if (!$token) {
            return response()->json([
                'message' => 'Неверный email или пароль'],
                Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
