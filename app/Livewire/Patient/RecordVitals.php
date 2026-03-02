<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use App\Domains\Patient\Requests\PatientVitalsRequest;

class RecordVitals extends Component
{
    use WithPagination;

    public Patient $patient;

    // Form properties
    public $systolic, $diastolic, $temperature, $pulse_rate, $spo2, $respiratory_rate, $weight, $nursing_note;
    public $recorded_at;

    /**
     * Use Route Model Binding by naming the parameter $patient 
     * exactly as defined in the route {patient}
     */
    public function mount(Patient $patient)
    {
        $this->patient = $patient;
        $this->recorded_at = now('Asia/Kabul')->format('Y-m-d\TH:i');
    }

    protected function rules(): array
    {
        return (new PatientVitalsRequest())->rules();
    }

    /**
     * Persist vital signs to database
     */
    public function save(PatientService $service): void
    {
        $data = $this->validate();

        try {
            $service->recordVitals($this->patient, $data);

            $this->dispatch(
                'notify',
                type: 'success',
                message: 'Clinical vitals recorded successfully.'
            );

            // Reset only vital fields, keep the patient context
            $this->reset(['systolic', 'diastolic', 'temperature', 'pulse_rate', 'spo2', 'respiratory_rate', 'weight', 'nursing_note']);
            $this->recorded_at = now('Asia/Kabul')->format('Y-m-d\TH:i');
        } catch (\Exception $e) {
            logger($e->getMessage());
            $this->dispatch(
                'notify',
                type: 'error',
                message: 'Error occurred while saving vitals. ' . $e->getMessage()
            );
        }
    }

    public function render(PatientService $service)
    {
        return view('livewire.patient.record-vitals', [
            'vitalsHistory' => $service->getPatientVitals($this->patient, 10)
        ])->layout('layouts.app');
    }
}
