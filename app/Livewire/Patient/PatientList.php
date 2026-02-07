<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Models\Patient;

class PatientList extends Component
{
    public function mount()
    {
        abort_unless(
            auth()->user()->can('patient.view'),
            403
        );
    }

    public function render()
    {
        return view('livewire.patient.patient-list', [
            'patients' => Patient::latest()->paginate(10),
        ])->layout('layouts.app');
    }
}
