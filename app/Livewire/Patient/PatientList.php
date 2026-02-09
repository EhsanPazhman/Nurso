<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Patient\Repositories\PatientRepository;

class PatientList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $status = '';

    public function mount()
    {
        abort_unless(auth()->user()->can('patient.view'), 403);
    }

    public function render(PatientRepository $repository)
    {
        return view('livewire.patient.patient-list', [
            'patients' => $repository->paginate(
                perPage: 10,
                search: $this->search,
                status: $this->status
            ),
        ])->layout('layouts.app');
    }
}
