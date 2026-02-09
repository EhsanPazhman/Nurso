<?php

namespace App\Livewire;

use Livewire\Component;
use App\Domains\Patient\Repositories\PatientRepository;

class Dashboard extends Component
{
    public function mount()
    {
        abort_unless(auth()->check(), 403);
    }

    public function render(PatientRepository $repository)
    {
        return view('livewire.dashboard', [
            'recentPatients' => auth()->user()->can('patient.view')
                ? $repository->getRecent(5)
                : collect(),
        ])->layout('layouts.app');
    }
}
