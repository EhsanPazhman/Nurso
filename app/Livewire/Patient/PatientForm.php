<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use App\Domains\Department\Models\Department;
use App\Domains\Auth\Models\User;

class PatientForm extends Component
{
    /**
     * The Patient instance being edited. Null if creating.
     */
    public ?Patient $patient = null;

    /**
     * Form fields
     */
    public $first_name, $last_name, $father_name, $gender = null;
    public $date_of_birth, $phone, $secondary_phone, $national_id;
    public $address, $status = null;
    public $department_id, $doctor_id;

    /**
     * Mount component
     */
    public function mount(Patient $patient)
    {
        if ($patient->exists) {
            $this->patient = $patient;

            abort_unless(auth()->user()->can('update', $this->patient), 403);

            $this->fillPatientData();
        } else {
            abort_unless(auth()->user()->can('create', Patient::class), 403);

            $this->initializeNewPatient();
        }
    }

    /**
     * Fill the form fields from the existing patient
     */
    protected function fillPatientData(): void
    {
        $this->first_name = $this->patient->first_name;
        $this->last_name = $this->patient->last_name;
        $this->father_name = $this->patient->father_name;
        $this->gender = (string) $this->patient->gender;
        $this->date_of_birth = $this->patient->date_of_birth?->format('Y-m-d');
        $this->phone = $this->patient->phone;
        $this->secondary_phone = $this->patient->secondary_phone;
        $this->national_id = $this->patient->national_id;
        $this->address = $this->patient->address;
        $this->status = (string) $this->patient->status;
        $this->department_id = (string) $this->patient->department_id;
        $this->doctor_id = $this->patient->doctor_id ? (string) $this->patient->doctor_id : null;
    }

    /**
     * Initialize default values for a new patient
     */
    protected function initializeNewPatient(): void
    {
        $this->gender = '';
        $this->status = '';
        $this->department_id = '';
        $this->doctor_id = '';
    }

    /**
     * Validation rules
     */
    protected function rules(): array
    {
        return [
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'father_name'     => 'required|string|max:255',
            'gender'          => 'required|in:male,female',
            'date_of_birth'   => 'nullable|date',
            'phone'           => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'national_id'     => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'status'          => 'required|in:active,inactive,deceased',
            'department_id'   => 'required|exists:departments,id',
            'doctor_id'       => 'nullable|exists:users,id',
        ];
    }

    /**
     * Save or update the patient
     *
     * @param PatientService $service
     */
    public function save(PatientService $service): void
    {
        $validatedData = $this->validate();

        try {
            if ($this->patient) {
                // Instance-based authorization already done in mount
                $service->update($this->patient, $validatedData);
                $msg = 'Patient updated successfully';
            } else {
                // Class-based authorization already done in mount
                $service->create($validatedData);
                $msg = 'Patient registered successfully';
            }

            $this->dispatch('notify', type: 'success', message: $msg);
        } catch (\DomainException $e) {
            $this->addError('national_id', $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred during save.');
        }
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.patient.patient-form', [
            'departments' => [],
            'doctors' => []
        ])->layout('layouts.app');
    }
}
