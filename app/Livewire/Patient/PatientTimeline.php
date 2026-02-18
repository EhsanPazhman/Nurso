<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Domains\Patient\Models\Patient;
use App\Domains\Department\Models\Department;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Auth;

class PatientTimeline extends Component
{
    public $patientId;

    protected function getHumanValue($key, $value)
    {
        if ($value === null || $value === '') return 'None';
        return match ($key) {
            'doctor_id' => User::find($value)?->name ?? 'Unknown Physician',
            'department_id' => Department::find($value)?->name ?? 'Unknown Dept',
            'status', 'gender' => ucfirst($value),
            default => $value,
        };
    }

    public function render()
    {
        $activities = Activity::where('subject_type', Patient::class)
            ->where('subject_id', $this->patientId)
            ->with('causer')
            ->latest()
            ->get()
            ->map(function ($activity) {
                $activity->time_formatted = $activity->created_at->format('h:i A');
                $activity->date_formatted = $activity->created_at->format('Y/m/d');

                if ($activity->description === 'updated' && isset($activity->changes['attributes'])) {
                    $changes = [];
                    foreach ($activity->changes['attributes'] as $key => $value) {
                        if (in_array($key, ['updated_at', 'deleted_at'])) continue;
                        $changes[] = [
                            'label' => str_replace('_', ' ', $key),
                            'old'   => $this->getHumanValue($key, $activity->changes['old'][$key] ?? null),
                            'new'   => $this->getHumanValue($key, $value),
                        ];
                    }
                    $activity->custom_changes = $changes;
                }
                return $activity;
            })
            ->reject(function ($activity) {
                if ($activity->description === 'updated' && empty($activity->custom_changes)) {
                    return true;
                }
                return false;
            });

        return view('livewire.patient.patient-timeline', ['activities' => $activities]);
    }
}
