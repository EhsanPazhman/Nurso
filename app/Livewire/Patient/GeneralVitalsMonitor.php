<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Services\PatientService;

class GeneralVitalsMonitor extends Component
{
    public function render(PatientService $service)
    {
        return view('livewire.patient.general-vitals-monitor', [
            // Ensure this method exists in PatientService
            'vitals' => $service->getDepartmentVitals()
        ])->layout('layouts.app');
    }
}
