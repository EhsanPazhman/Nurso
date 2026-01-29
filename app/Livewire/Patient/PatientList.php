<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;

class PatientList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';
    public int $perPage = 15;

    protected $queryString = ['search', 'page'];

    public function render()
    {
        $response = Http::withToken(auth()->user()->currentAccessToken()->plainTextToken ?? '')
            ->get(config('app.url') . '/api/patients', [
                'search' => $this->search,
                'per_page' => $this->perPage,
            ]);

        return view('livewire.patient.patient-list', [
            'patients' => $response->json()
        ]);
    }
}
