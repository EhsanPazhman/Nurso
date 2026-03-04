<?php

namespace App\Livewire;

use App\Domains\Staff\Models\User;
use App\Domains\Patient\Services\PatientService;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(PatientService $service)
    {
        $user = auth()->user();

        return view('livewire.dashboard', [
            'totalPatients'   => $service->getTotalCount(),
            'todayAdmissions' => $service->getTodayAdmissionsCount(),

            'activeDoctorsCount' => User::where('is_active', true)
                ->whereHas('roles', fn($q) => $q->where('name', 'doctor'))
                ->count(),

            'recentPatients' => $user->can('viewAny', \App\Domains\Patient\Models\Patient::class)
                ? $service->getRecent(6)
                : collect(),

            'occupancyRate' => 75,
        ])->layout('layouts.app');
    }
}
