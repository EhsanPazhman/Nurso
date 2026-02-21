<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Services\PatientService;
use App\Domains\Department\Models\Department;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Auth;

class PatientForm extends Component
{
    public ?Patient $patient = null;

    public $first_name, $last_name, $father_name, $gender = null;
    public $date_of_birth, $phone, $secondary_phone, $national_id;
    public $address, $status = null;
    public $department_id, $doctor_id;

    public function mount(?int $patientId = null)
    {
        if ($patientId) {
            abort_unless(Auth::user()->can('patient.update'), 403);

            $this->patient = Patient::findOrFail($patientId);

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
        } else {
            abort_unless(Auth::user()->can('patient.create'), 403);
            $this->gender = '';
            $this->status = '';
            $this->department_id = '';
        }
    }

    protected function rules()
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

    public function save(PatientService $service)
    {
        $validatedData = $this->validate();

        try {
            if ($this->patient) {
                $service->update($this->patient, $validatedData);
                $msg = 'Patient updated successfully';
            } else {
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

    public function render()
    {
        return view('livewire.patient.patient-form', [
            'departments' => Department::where('is_active', true)->get(),
            'doctors' => User::whereHas('roles', fn($q) => $q->where('name', 'doctor'))
                ->when($this->department_id, fn($q) => $q->where('department_id', $this->department_id))
                ->get(),
        ])->layout('layouts.app');
    }
}
