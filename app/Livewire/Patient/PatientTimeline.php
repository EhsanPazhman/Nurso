<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Services\PatientService;

class PatientTimeline extends Component
{
    public $patientId;

    public function render(PatientService $patientService)
    {
        $activities = $patientService->getPatientTimeline($this->patientId);

        return view('livewire.patient.patient-timeline', [
            'activities' => $activities
        ]);
    }
}