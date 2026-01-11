<?php

namespace App\Livewire\Patient;

use App\Models\Vital;
use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\Validate;

class PatientVitals extends Component
{
    public $patientId;
    public $patient;

    #[Validate('required|numeric|min:30|max:45')]
    public ?int $temperature = null;
    #[Validate('required|numeric|min:40|max:180')]
    public ?int $heart_rate = null;
    #[Validate('required|numeric|min:10|max:30')]
    public ?int $respiratory_rate = null;
    #[Validate('required|numeric|min:80|max:200')]
    public ?int $blood_pressure_systolic = null;
    #[Validate('required|numeric|min:40|max:120')]
    public ?int $blood_pressure_diastolic = null;
    #[Validate('required|numeric|min:70|max:100')]
    public ?int $oxygen_saturation = null;

    public function mount($patientId)
    {
        $this->patient = Patient::findOrFail($patientId);
        $this->patientId = $this->patient->id;
    }
    public function save()
    {
        $this->validate();
        Vital::Create(
            [
                'patient_id'       => $this->patientId,
                'temperature' => $this->temperature,
                'heart_rate' => $this->heart_rate,
                'respiratory_rate' => $this->respiratory_rate,
                'blood_pressure_systolic' => $this->blood_pressure_systolic,
                'blood_pressure_diastolic' => $this->blood_pressure_diastolic,
                'oxygen_saturation' => $this->oxygen_saturation,
            ]
        );
        session()->flash('success', 'Patient data processed successfully!');
        return redirect()->route('patients.index');
    }

    public function render()
    {
        return view('livewire.patient.patient-vitals', [
            'history' => Vital::where('patient_id', $this->patientId)->latest()->take(10)->get()
        ])->layout('layouts.app');
    }
}
