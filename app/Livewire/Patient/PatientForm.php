<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use Illuminate\Support\Facades\Log;

class PatientForm extends Component
{
    public ?Patient $patient = null;

    // Form Properties
    public $first_name, $last_name, $father_name, $gender;
    public $date_of_birth, $phone, $secondary_phone, $national_id;
    public $address, $status, $department_id, $doctor_id;

    public function mount(?Patient $patient = null)
    {
        if ($patient && $patient->exists) {
            $this->patient = $patient;
            abort_unless(auth()->user()->can('update', $this->patient), 403);
            $this->fill($this->patient->toArray());
            $this->date_of_birth = $this->patient->date_of_birth?->format('Y-m-d');
        } else {
            abort_unless(auth()->user()->can('create', Patient::class), 403);
            $this->status = 'active';
            $this->gender = 'male';
        }
    }

    protected function rules(): array
    {
        return [
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'father_name'     => 'nullable|string|max:100',
            'gender'          => 'required|in:male,female',
            'date_of_birth'   => 'nullable|date|before:today',
            'phone'           => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'national_id'     => 'nullable|string|max:50',
            'address'         => 'nullable|string|max:500',
            'status'          => 'required|in:active,inactive,deceased',
            'department_id'   => 'required|exists:departments,id',
            'doctor_id'       => 'nullable|exists:users,id',
        ];
    }

    public function save(PatientService $service)
    {
        $validatedData = $this->validate();

        try {
            if ($this->patient && $this->patient->exists) {
                $service->update($this->patient, $validatedData);
                $message = 'Patient updated successfully.';
            } else {
                $service->create($validatedData);
                $message = 'Patient registered successfully.';
            }

            $this->dispatch('notify', type: 'success', message: $message);
            return redirect()->route('patients.index');
        } catch (\DomainException $e) {
            $this->addError('national_id', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Patient Save Error: ' . $e->getMessage());
            $this->dispatch('notify', type: 'error', message: 'An unexpected error occurred.');
        }
    }

    public function render(PatientService $service)
    {
        return view('livewire.patient.patient-form', [
            'departments' => $service->getActiveDepartments(),
            'doctors' => $service->getDoctorsByDepartment($this->department_id),
        ])->layout('layouts.app');
    }
}
