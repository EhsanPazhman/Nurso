<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Livewire\Attributes\Validate;
use Livewire\Component;


class PatientForm extends Component
{
    public array $genders = [
        'male'   => 'Male',
        'female' => 'Female',
        'other'  => 'Other',
    ];

    public array $statuses = [
        'admitted'           => 'Admitted',
        'discharged'         => 'Discharged',
        'under_observation'  => 'Under Observation',
    ];

    public ?int $patientId = null;

    #[Validate('required|string|min:3|max:100')]
    public string $name = '';

    #[Validate('required|integer|min:1|max:120')]
    public ?int $age = null;

    #[Validate('required|integer|min:1|max:500')]
    public ?int $bed_number = null;

    #[Validate('required|in:male,female,other')]
    public string $gender = '';

    #[Validate('required|in:admitted,discharged,under_observation')]
    public string $status = '';
    public function mount($patientId = null)
    {
        if ($patientId) {
            $patient = Patient::findOrFail($patientId);
            $this->patientId  = $patient->id;
            $this->name       = $patient->name;
            $this->age        = $patient->age;
            $this->bed_number = $patient->bed_number;
            $this->gender     = $patient->gender;
            $this->status     = $patient->status;
        }
    }
    public function save()
    {
        $this->validate();

        Patient::updateOrCreate(
            ['id' => $this->patientId],
            [
                'name'       => $this->name,
                'age'        => $this->age,
                'bed_number' => $this->bed_number,
                'gender'     => $this->gender,
                'status'     => $this->status,
            ]
        );
        session()->flash('success', 'Patient data processed successfully!');
        return redirect()->route('patients.index');
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function render()
    {
        return view('livewire.patient.patient-form')->layout('layouts.app');
    }
}
