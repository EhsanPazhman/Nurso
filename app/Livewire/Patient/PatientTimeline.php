<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Domains\Patient\Models\Patient;
use App\Domains\Department\Models\Department;
use App\Domains\Auth\Models\User;

class PatientTimeline extends Component
{
    public $patientId;

    protected function getHumanValue(string $key, $value): string
    {
        if ($value === null || $value === '') return 'N/A';

        return match ($key) {
            'doctor_id' => User::find($value)?->name ?? 'Deleted User',
            'department_id' => Department::find($value)?->name ?? 'Deleted Dept',
            'status', 'gender' => str($value)->headline(),
            default => (string) $value,
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
                // Ensure correct timezone for hospital staff
                $localTime = $activity->created_at->timezone('Asia/Kabul');
                $activity->time_formatted = $localTime->format('h:i A');
                $activity->date_formatted = $localTime->format('Y/m/d');

                if ($activity->description === 'updated' && isset($activity->changes['attributes'])) {
                    $changes = [];
                    foreach ($activity->changes['attributes'] as $key => $value) {
                        if (in_array($key, ['updated_at', 'id'])) continue;

                        $oldValue = $activity->changes['old'][$key] ?? null;
                        if ($oldValue == $value) continue;

                        $changes[] = [
                            'label' => str_replace('_', ' ', $key),
                            'old'   => $this->getHumanValue($key, $oldValue),
                            'new'   => $this->getHumanValue($key, $value),
                        ];
                    }
                    $activity->custom_changes = $changes;
                }
                return $activity;
            })
            ->reject(fn($a) => $a->description === 'updated' && empty($a->custom_changes));

        return view('livewire.patient.patient-timeline', ['activities' => $activities]);
    }
}
