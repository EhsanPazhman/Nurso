<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Patient\Models\Vital;

class GeneralVitalsMonitor extends Component
{
    use WithPagination;

    public function render()
    {
        $user = auth()->user();

        $query = Vital::with(['patient', 'user'])
            ->latest('recorded_at');

        // if ($user->role !== 'hospital_admin') {
        //     $query->whereHas('patient', function ($q) use ($user) {
        //         $q->where('department_id', $user->department_id);
        //     });
        // }

        return view('livewire.patient.general-vitals-monitor', [
            'vitals' => $query->paginate(20)
        ])->layout('layouts.app');
    }
}
