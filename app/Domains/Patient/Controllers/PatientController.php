<?php

namespace App\Domains\Patient\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use App\Domains\Patient\Requests\StorePatientRequest;
use App\Domains\Patient\Requests\PatientVitalsRequest;
use App\Domains\Patient\Requests\UpdatePatientRequest;
use App\Domains\Patient\Repositories\PatientRepository;
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

        return response()->json($patients);
    }

    public function store(StorePatientRequest $request): JsonResponse
    {
        // Authorization is handled inside the FormRequest
        $patient = $this->service->create($request->validated());

        return response()->json([
            'message' => 'Patient created successfully',
            'data' => $patient
        ], 201);
    }

    public function storeVitals(PatientVitalsRequest $request, Patient $patient): JsonResponse
    {
        // Authorization is handled inside the FormRequest
        $vital = $this->service->recordVitals($patient, $request->validated());

        return response()->json([
            'message' => 'Vitals recorded successfully',
            'data' => $vital
        ], 201);
    }

    public function show(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);
        return response()->json($patient->load(['department', 'doctor', 'latestVitals']));
    }

    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        // Authorization is handled inside the FormRequest
        $this->service->update($patient, $request->validated());

        return response()->json([
            'message' => 'Patient updated successfully',
            'data' => $patient->fresh()
        ]);
    }

    public function destroy(Patient $patient): JsonResponse
    {
        $this->authorize('delete', $patient);
        $this->service->delete($patient);

        return response()->json(['message' => 'Patient deleted successfully']);
    }

    public function restore(int $id): JsonResponse
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $this->authorize('restore', $patient);

        $this->service->restore($id);

        return response()->json([
            'message' => 'Patient restored successfully',
            'data' => $patient->fresh()
        ]);
    }
}
