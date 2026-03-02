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
        $vitals = $patientService->getDepartmentVitals(perPage: 10);

        return view('livewire.patient.general-vitals-monitor', [
            'vitals' => $vitals
        ])->layout('layouts.app');
    }
}
