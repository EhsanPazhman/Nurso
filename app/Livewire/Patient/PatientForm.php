<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Domains\Patient\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientForm extends Component
{
    public ?Patient $patient = null;

    // Define all fields as public properties so Livewire can bind to them
    public $first_name, $last_name, $father_name, $gender = 'male';
    public $date_of_birth, $phone, $secondary_phone, $national_id;
    public $address, $status = 'active';

    public function mount(?int $patientId = null)
    {
        if ($patientId) {
            abort_unless(Auth::user()->can('patient.update'), 403);
            $this->patient = Patient::findOrFail($patientId);

            // Fill properties with existing data for editing
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
            'father_name'     => 'nullable|string|max:255',
            'gender'          => 'required|in:male,female',
            'date_of_birth'   => 'nullable|date',
            'phone'           => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'national_id'     => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'status'          => 'required|in:active,inactive,deceased',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->patient) {
            // Add who updated it
            $validatedData['updated_by'] = Auth::id();

            $this->patient->update($validatedData);
            session()->flash('success', 'Patient updated successfully');
        } else {
            // Add required system fields for new records
            $validatedData['created_by'] = Auth::id();
            $validatedData['patient_code'] = 'PAT-' . strtoupper(uniqid()); // Example auto-code

            Patient::create($validatedData);
            session()->flash('success', 'Patient created successfully');
        }

        return redirect()->route('patients');
    }

    public function render()
    {
        return view('livewire.patient.patient-form')
            ->layout('layouts.app');
    }
}
