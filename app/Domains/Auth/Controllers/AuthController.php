<?php

namespace App\Domains\Auth\Controllers;

use DomainException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Auth\Requests\RegisterRequest;
use App\Domains\Auth\Requests\UpdateStaffRequest;
use App\Domains\Auth\Resources\UserResource;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $user  = $this->authService->attemptLogin(
                $credentials['email'],
                $credentials['password']
            );

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'token' => $token,
                    'user'  => new UserResource($user->load(['roles', 'department'])),
                ]
            ]);
        } catch (DomainException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Staff registered successfully',
            'data'    => new UserResource($user->load(['roles', 'department'])),
        ], 201);
    }

    public function update(UpdateStaffRequest $request, User $staff): JsonResponse
    {
        $user = $this->authService->updateStaff($staff, $request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Staff updated successfully',
            'data'    => new UserResource($user->load(['roles', 'department'])),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => new UserResource($request->user()->load(['roles', 'department'])),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logged out successfully',
        ]);
    }
}