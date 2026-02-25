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

    /**
     * Constructor to inject service and repository dependencies.
     */
    public function __construct(
        protected PatientService $service,
        protected PatientRepository $repository
    ) {}

    /* =========================
     |  List Patients
     |  GET /patients
     |  Policy: viewAny(Patient::class)
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
     |  POST /patients
     |  Policy: create(Patient::class)
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
     |  Record Patient Vitals
     |  POST /patients/{patient}/vitals
     |  Policy: recordVitals($patient)
     | =========================
     */
    public function storeVitals(PatientVitalsRequest $request, Patient $patient): JsonResponse
    {
        $this->authorize('recordVitals', $patient);

        $vital = $this->service->recordVitals($patient, $request->validated());

        return response()->json([
            'message' => 'Vitals recorded successfully',
            'data' => $vital
        ], 201);
    }

    /* =========================
     |  Show Single Patient
     |  GET /patients/{patient}
     |  Policy: view($patient)
     | =========================
     */
    public function show(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);

        return response()->json($patient);
    }

    /* =========================
     |  Update Patient
     |  PUT/PATCH /patients/{patient}
     |  Policy: update($patient)
     | =========================
     */
    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        $this->authorize('update', $patient);

        $updated = $this->service->update($patient, $request->validated());

        return response()->json([
            'message' => 'Patient updated successfully',
            'data' => $updated
        ]);
    }

    /* =========================
     |  Soft Delete Patient
     |  DELETE /patients/{patient}
     |  Policy: delete($patient)
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
     |  Restore Soft-Deleted Patient
     |  POST /patients/{id}/restore
     |  Policy: restore($patient)
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
