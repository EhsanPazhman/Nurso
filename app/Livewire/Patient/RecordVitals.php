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

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
        $this->recorded_at = now()->format('Y-m-d\TH:i');
    }

    protected function rules()
    {
        return (new PatientVitalsRequest())->rules();
    }

    public function save(PatientService $service)
    {
        $data = $this->validate();

        $service->recordVitals($this->patient, $data);

        $this->dispatch('vitals-recorded');
        $this->reset(['systolic', 'diastolic', 'temperature', 'pulse_rate', 'spo2', 'respiratory_rate', 'weight', 'nursing_note']);

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Clinical vitals recorded.']);
    }

    public function render()
    {
        return view('livewire.patient.record-vitals');
    }
}
