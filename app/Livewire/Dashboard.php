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
        $user = auth()->user();

        return view('livewire.dashboard', [
            'totalPatients' => $repository->getTotalCount(),
            'todayAdmissions' => $repository->getTodayAdmissionsCount(),

            'activeDoctorsCount' => \App\Domains\Auth\Models\User::where('is_active', 1)
                ->whereHas('roles', fn($q) => $q->where('name', 'doctor'))->count(),

            'recentPatients' => $user->can('patient.view') ? $repository->getRecent(6) : collect(),

            'occupancyRate' => 75,
        ])->layout('layouts.app');
    }
}
