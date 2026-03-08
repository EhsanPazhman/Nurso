<?php

namespace App\Domains\Patient\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use App\Domains\Patient\Requests\StorePatientRequest;
use App\Domains\VitalSign\Requests\VitalSignRequest;
use App\Domains\Patient\Requests\UpdatePatientRequest;
use App\Domains\Patient\Repositories\PatientRepository;
use App\Domains\Patient\Resources\PatientResource;
use App\Domains\Patient\Resources\VitalResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PatientController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected PatientService $service,
        protected PatientRepository $repository
    ) {}

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Patient::class);

        $patients = $this->repository->paginate(
            perPage: $request->integer('per_page', 15),
            filters: $request->only(['search', 'status'])
        );

        return response()->json([
            'status' => 'success',
            'data'   => PatientResource::collection($patients)
        ]);
    }

    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = $this->service->create($request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Patient created successfully',
            'data'    => new PatientResource($patient),
        ], 201);
    }

    public function storeVitals(VitalSignRequest $request, Patient $patient): JsonResponse
    {
        $vital = $this->service->recordVitals($patient, $request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Vitals recorded successfully',
            'data'    => new VitalResource($vital),
        ], 201);
    }

    public function show(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);

        return response()->json([
            'status' => 'success',
            'data'   => new PatientResource($patient->load(['department', 'doctor', 'latestVitals']))
        ]);
    }

    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        $this->service->update($patient, $request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Patient updated successfully',
            'data'    => new PatientResource($patient->fresh()->load(['department', 'doctor'])),
        ]);
    }

    public function destroy(Patient $patient): JsonResponse
    {
        $this->authorize('delete', $patient);

        $this->service->delete($patient);

        return response()->json([
            'status'  => 'success',
            'message' => 'Patient deleted successfully',
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $patient = Patient::withTrashed()->findOrFail($id);

        $this->authorize('restore', $patient);

        $this->service->restore($patient);

        return response()->json([
            'status'  => 'success',
            'message' => 'Patient restored successfully',
            'data'    => new PatientResource($patient->fresh()),
        ]);
    }
}