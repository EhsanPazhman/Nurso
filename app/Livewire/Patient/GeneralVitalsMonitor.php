<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Patient\Services\PatientService;

class GeneralVitalsMonitor extends Component
{
    use WithPagination;

    public function render(PatientService $patientService)
    {
        return view('livewire.patient.general-vitals-monitor', [
            'vitals' => $patientService->getDepartmentVitals(12) 
        ])->layout('layouts.app');
    }
}
