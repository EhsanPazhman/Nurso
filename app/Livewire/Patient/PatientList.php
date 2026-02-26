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

    public string $search = '';
    public string $status = '';
    public $fromDate;
    public $toDate;
    public bool $showTrashed = false;

    // Reset pagination on filter change
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'status', 'fromDate', 'toDate', 'showTrashed'])) {
            $this->resetPage();
        }
    }

    public function mount()
    {
        abort_unless(auth()->user()->can('viewAny', Patient::class), 403);
    }

    public function deletePatient(int $id, PatientService $service)
    {
        $patient = Patient::findOrFail($id);
        $this->authorize('delete', $patient);
        $service->delete($patient);
        $this->dispatch('notify', type: 'success', message: 'Patient moved to trash');
    }

    public function restorePatient(int $id, PatientService $service)
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $this->authorize('restore', $patient);
        $service->restore($id);
        $this->dispatch('notify', type: 'success', message: 'Patient restored successfully');
    }

    public function render(PatientRepository $repository)
    {
        return view('livewire.patient.patient-list', [
            'patients' => $repository->paginate(10, [
                'search' => $this->search,
                'status' => $this->status,
                'only_trashed' => $this->showTrashed,
                'from_date' => $this->fromDate,
                'to_date' => $this->toDate
            ])
        ])->layout('layouts.app');
    }
}
