<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use App\Domains\Patient\Repositories\PatientRepository;

class PatientList extends Component
{
    use WithPagination;

    /**
     * Search query string
     */
    public string $search = '';

    /**
     * Filter by status
     */
    public string $status = '';

    /**
     * Date range filters
     */
    public $fromDate;
    public $toDate;

    /**
     * Show soft-deleted patients
     */
    public bool $showTrashed = false;

    /**
     * Reset pagination when filters update
     */
    public function updatingFromDate()
    {
        $this->resetPage();
    }
    public function updatingToDate()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingStatus()
    {
        $this->resetPage();
    }

    /**
     * Component mount lifecycle
     * Checks that the user has permission to view patients
     */
    public function mount()
    {
        abort_unless(auth()->user()->can('viewAny', Patient::class), 403);
    }

    /**
     * Soft delete a patient
     * @param int $id
     * @param PatientService $service
     */
    public function deletePatient(int $id, PatientService $service)
    {
        $patient = Patient::findOrFail($id);
        $this->authorize('delete', $patient);
        $service->delete($patient);
        $this->dispatch('notify', type: 'success', message: 'Patient deleted successfully');
    }

    /**
     * Change patient status
     * @param int $id
     * @param string $status
     * @param PatientService $service
     */
    public function changeStatus(int $id, string $status, PatientService $service)
    {
        $patient = Patient::findOrFail($id);
        $this->authorizeAction('update', $patient, $service, fn() => $service->changeStatus($patient, $status), 'Status updated');
    }

    /**
     * Restore soft-deleted patient
     * @param int $id
     * @param PatientService $service
     */
    public function restorePatient($id, PatientService $service)
    {
        $patient = Patient::withTrashed()->findOrFail($id);

        $this->authorize('restore', $patient);

        $service->restore($id);

        $this->dispatch('notify', type: 'success', message: 'Patient restored successfully');
    }
    /**
     * Render the patient list
     * @param PatientRepository $repository
     */
    public function render(PatientRepository $repository)
    {
        $patients = $repository->paginate(
            perPage: 10,
            search: $this->search,
            status: $this->status,
            onlyTrashed: $this->showTrashed,
            fromDate: $this->fromDate,
            toDate: $this->toDate
        );

        return view('livewire.patient.patient-list', [
            'patients' => $patients,
        ])->layout('layouts.app');
    }

    /**
     * Helper to authorize actions on a patient and execute callback
     */
    protected function authorizeAction(string $ability, Patient $patient, PatientService $service, ?callable $callback = null, string $successMessage = '')
    {
        abort_unless(auth()->user()->can($ability, $patient), 403);

        if ($callback) {
            $callback();
            $this->dispatch('notify', message: $successMessage, type: 'success');
        }
    }
}
