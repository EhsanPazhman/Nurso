<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class PatientForm extends Component
{
    public ?int $patientId = null;

    public array $form = [
        'first_name' => '',
        'last_name' => '',
        'father_name' => '',
        'gender' => '',
        'date_of_birth' => '',
        'phone' => '',
        'secondary_phone' => '',
        'national_id' => '',
        'address' => '',
    ];

    public function mount(?int $patientId = null)
    {
        if ($patientId) {
            $this->patientId = $patientId;

            $response = Http::withToken(auth()->user()->currentAccessToken()->plainTextToken ?? '')
                ->get(config('app.url') . "/api/patients/{$patientId}");

            $this->form = array_merge($this->form, $response->json());
        }
    }

    public function save()
    {
        $url = config('app.url') . '/api/patients';
        $method = 'post';

        if ($this->patientId) {
            $url .= "/{$this->patientId}";
            $method = 'put';
        }

        Http::withToken(auth()->user()->currentAccessToken()->plainTextToken ?? '')
            ->{$method}($url, $this->form);

        return redirect()->route('patients.index');
    }

    public function render()
    {
        return view('livewire.patient.patient-form');
    }
}
