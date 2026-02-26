<?php

namespace App\Livewire;

use Livewire\Component;
use App\Domains\Patient\Repositories\PatientRepository;
use App\Domains\Auth\Models\User;

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
            // Using the restored methods in Repository
            'totalPatients'    => $repository->getTotalCount(),
            'todayAdmissions'  => $repository->getTodayAdmissionsCount(),

            // Count active doctors
            'activeDoctorsCount' => User::where('is_active', true)
                ->whereHas('roles', function ($q) {
                    $q->where('name', 'doctor');
                })->count(),

            // Fetch recent patients based on user permissions
            'recentPatients' => $user->can('viewAny', \App\Domains\Patient\Models\Patient::class)
                ? $repository->getRecent(6)
                : collect(),

            'occupancyRate' => 75, // Placeholder for future logic
        ])->layout('layouts.app');
    }
}
