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

    public $first_name, $last_name, $father_name, $gender = 'male';
    public $date_of_birth, $phone, $secondary_phone, $national_id;
    public $address, $status = 'active';
    public $department_id, $doctor_id;

    public function mount(?int $patientId = null)
    {
        if ($patientId) {
            abort_unless(Auth::user()->can('patient.update'), 403);
            $this->patient = Patient::findOrFail($patientId);
            $this->fill($this->patient->toArray());
        } else {
            abort_unless(Auth::user()->can('patient.create'), 403);
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
            'department_id'   => 'required|exists:departments,id', // Mandatory for isolation
            'doctor_id'       => 'nullable|exists:users,id',
        ];
    }

    public function save(PatientService $service)
    {
        $validatedData = $this->validate();

        try {
            if ($this->patient) {
                $validatedData['updated_by'] = Auth::id();
                $service->update($this->patient, $validatedData);
                $msg = 'Patient updated successfully';
            } else {
                $validatedData['created_by'] = Auth::id();
                $service->create($validatedData);
                $msg = 'Patient registered successfully';
            }

            $this->dispatch('notify', type: 'success', message: $msg);
            return $this->redirectRoute('patients', navigate: true);
        } catch (\DomainException $e) {
            $this->addError('national_id', $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.patient.patient-form', [
            'departments' => Department::where('is_active', true)->get(),
            'doctors' => User::whereHas('roles', fn($q) => $q->where('name', 'doctor'))->get(),
        ])->layout('layouts.app');
    }
}
