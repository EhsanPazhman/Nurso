<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class PatientIndex extends Component
{
    use WithPagination;
    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deletePatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        session()->flash('success', 'Patient record removed safely.');
    }

    public function render()
    {
        return view('livewire.patient.patient-index', [
            'patients' => Patient::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('bed_number', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(1)
        ])->layout('layouts.app');
    }
}
