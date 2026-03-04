<?php

namespace App\Domains\Staff\Controllers;

use DomainException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Domains\Staff\Models\User;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Auth\Requests\RegisterRequest;
use App\Domains\Auth\Requests\UpdateStaffRequest;
use App\Domains\Staff\Resources\StaffResource;

class StaffController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

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
}
