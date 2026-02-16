<?php

namespace App\Domains\Auth\Controllers;

use DomainException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Auth\Requests\RegisterRequest;
use App\Domains\Auth\Requests\UpdateStaffRequest;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $user = $this->authService->attemptLogin($request->email, $request->password);
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token'  => $token,
                'user'   => $user->load('roles'),
            ]);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Staff registered successfully',
            'data'    => $user->load('roles'),
        ], 201);
    }

    public function update(UpdateStaffRequest $request, $id): JsonResponse
    {
        $user = $this->authService->updateStaff($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $user->load('roles')
        ]);
    }
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $request->user()->load(['roles', 'department'])
        ]);
    }
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
}
