<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Services\PatientService;

class GeneralVitalsMonitor extends Component
{

    public function render(PatientService $patientService)
    {
        return view('livewire.Patient.general-vitals-monitor', [
            'vitals' => $patientService->getDepartmentVitals()
        ])->layout('layouts.app');
    }
}
