<?php

namespace App\Domains\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use App\Domains\Patient\Repositories\PatientRepository;
use App\Domains\Patient\Requests\StorePatientRequest;
use App\Domains\Patient\Requests\UpdatePatientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PatientController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        protected PatientService $service,
        protected PatientRepository $repository
    ) {}

    /* =========================
     |  List Patients
     | =========================
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Patient::class);

        $patients = $this->repository->paginate(
            perPage: $request->integer('per_page', 15),
            search: $request->string('search')->toString(),
            status: $request->string('status')->toString()
        );

        return response()->json($patients);
    }

    /* =========================
     |  Store Patient
     | =========================
     */
    public function store(StorePatientRequest $request): JsonResponse
    {
        $this->authorize('create', Patient::class);

        $patient = $this->service->create($request->validated());

        return response()->json([
            'message' => 'Patient created successfully',
            'data' => $patient
        ], 201);
    }

    /* =========================
     |  Show Patient
     | =========================
     */
    public function show(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);

        return response()->json($patient);
    }

    /* =========================
     |  Update Patient
     | =========================
     */
    public function update(
        UpdatePatientRequest $request,
        Patient $patient
    ): JsonResponse {
        $this->authorize('update', $patient);

        $updated = $this->service->update($patient, $request->validated());

        return response()->json([
            'message' => 'Patient updated successfully',
            'data' => $updated
        ]);
    }

    /* =========================
     |  Delete Patient (Soft)
     | =========================
     */
    public function destroy(Patient $patient): JsonResponse
    {
        $this->authorize('delete', $patient);

        $this->service->delete($patient);

        return response()->json([
            'message' => 'Patient deleted successfully'
        ]);
    }

    /* =========================
     |  Restore Patient
     | =========================
     */
    public function restore(int $id): JsonResponse
    {
        $patient = $this->service->restore($id);

        $this->authorize('restore', $patient);

        return response()->json([
            'message' => 'Patient restored successfully',
            'data' => $patient
        ]);
    }
}
