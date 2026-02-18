<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Domains\Patient\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientTimeline extends Component
{
    public $patientId;

    public function render()
    {
        $user = Auth::user();

        $query = Activity::where('subject_type', Patient::class)
            ->where('subject_id', $this->patientId)
            ->with('causer')
            ->latest();

        if ($user->hasRole('doctor')) {
            $query->whereIn('description', ['created', 'updated'])
                ->where(function ($q) {
                    $q->where('properties->attributes->status', '!=', null)
                        ->orWhere('properties->attributes->doctor_id', '!=', null);
                });
        }

        if ($user->hasRole('nurse')) {
            $query->whereIn('description', ['updated'])
                ->where('properties->attributes->status', '!=', null);
        }

        return view('livewire.patient.patient-timeline', [
            'activities' => $query->get()
        ]);
    }
}
