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

    public $search = '';
    public $status = '';
    public bool $showTrashed = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        abort_unless(auth()->user()->can('patient.view'), 403);
    }

    public function deletePatient($id, PatientService $service)
    {
        $patient = Patient::findOrFail($id);
        $service->delete($patient);
        $this->dispatch('notify', message: 'Patient moved to trash', type: 'success');
    }

    public function changeStatus($id, $status, PatientService $service)
    {
        $patient = Patient::findOrFail($id);
        $service->changeStatus($patient, $status);
        $this->dispatch('notify', message: 'Status updated', type: 'success');
    }

    public function restorePatient($id, PatientService $service)
    {
        $service->restore($id);
        $this->dispatch('notify', message: 'Patient restored successfully', type: 'success');
    }
    public function render(PatientRepository $repository)
    {
        return view('livewire.patient.patient-list', [
            'patients' => $repository->paginate(
                perPage: 10,
                search: $this->search,
                status: $this->status,
                onlyTrashed: $this->showTrashed
            ),
        ])->layout('layouts.app');
    }
}
