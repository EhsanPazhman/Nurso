<?php

namespace App\Domains\VitalSign\Controllers;

use App\Domains\Patient\Models\Patient;
use App\Domains\VitalSign\Repositories\VitalSignRepository;
use App\Domains\VitalSign\Requests\VitalSignRequest;
use App\Domains\VitalSign\Resources\VitalSignResource;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class VitalSignController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected VitalSignService $service,
        protected VitalSignRepository $repository
    ) {}

    public function storeVitals(VitalSignRequest $request, Patient $patient): JsonResponse
    {
        $vital = $this->service->recordVitals($patient, $request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Vitals recorded successfully',
            'data'    => new VitalSignResource($vital),
        ], 201);
    }
}
