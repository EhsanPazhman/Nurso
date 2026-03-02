<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Patient\Services\PatientService;

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

    public function deletePatient(int $id, PatientService $service)
    {
        $patient = $service->find($id);

        $this->authorize('delete', $patient);

        $service->delete($patient);

        $this->dispatch('notify', type: 'success', message: 'Patient moved to trash');
    }

    public function restorePatient(int $id, PatientService $service)
    {
        $patient = $service->findWithTrashed($id);

        $this->authorize('restore', $patient);

        $service->restore($id);

        $this->dispatch('notify', type: 'success', message: 'Patient restored successfully');
    }

    public function changeStatus(int $id, string $status, PatientService $service)
    {
        $patient = $service->find($id);

        $this->authorize('update', $patient);

        $service->changeStatus($patient, $status);

        $this->dispatch('notify', type: 'success', message: 'Status updated');
    }


    public function render(PatientService $service)
    {
        return view('livewire.patient.patient-list', [
            'patients' => $service->paginate(10, [
                'search' => $this->search,
                'status' => $this->status,
                'only_trashed' => $this->showTrashed,
                'from_date' => $this->fromDate,
                'to_date' => $this->toDate
            ])
        ])->layout('layouts.app');
    }
}
