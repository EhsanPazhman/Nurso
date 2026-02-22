<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use App\Domains\Patient\Requests\PatientVitalsRequest;

class RecordVitals extends Component
{
    public Patient $patient;

    public $systolic, $diastolic, $temperature, $pulse_rate, $spo2, $respiratory_rate, $weight, $nursing_note;
    public $recorded_at;

    public function mount($patientId)
    {
        $this->patient = Patient::withTrashed()->findOrFail($patientId);
        $this->recorded_at = now('Asia/Kabul')->format('Y-m-d\TH:i');
    }

    protected function rules()
    {
        return (new PatientVitalsRequest())->rules();
    }

    public function save(PatientService $service)
    {
        $data = $this->validate();

        $service->recordVitals($this->patient, $data);

        $this->dispatch('notify', type: 'success', message: 'Clinical vitals recorded.');
        $this->reset(['systolic', 'diastolic', 'temperature', 'pulse_rate', 'spo2', 'respiratory_rate', 'weight', 'nursing_note']);
    }

    public function render()
    {
        $vitalsHistory = $this->patient->vitals()
            ->with('user')
            ->latest('recorded_at')
            ->take(10)
            ->get();

        return view('livewire.patient.record-vitals', [
            'vitalsHistory' => $vitalsHistory
        ])->layout('layouts.app');
    }
}
