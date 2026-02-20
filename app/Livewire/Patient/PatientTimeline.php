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
        if ($value === null || $value === '') return '---';

        return match ($key) {
            'doctor_id' => User::find($value)?->name ?? 'Deleted Staff',
            'department_id' => Department::find($value)?->name ?? 'Unknown Dept',
            'status' => str($value)->headline(),
            'gender' => str($value)->headline(),
            default => $value,
        };
    }


    public function render()
    {
        $patient = Patient::withTrashed()->findOrFail($this->patientId);
        if (auth()->user()->role !== 'admin' && auth()->user()->department_id !== $patient->department_id) {
            abort(403, 'You do not have access to this patient\'s history.');
        }
        $activities = Activity::where('subject_type', Patient::class)
            ->where('subject_id', $this->patientId)
            ->with('causer')
            ->latest()
            ->get()
            ->map(function ($activity) {
                $localTime = $activity->created_at->timezone('Asia/Kabul');

                $activity->time_formatted = $localTime->format('h:i A');
                $activity->date_formatted = $localTime->format('Y/m/d');

                if ($activity->description === 'updated' && isset($activity->changes['attributes'])) {
                    $changes = [];
                    $ignoredFields = ['updated_at', 'deleted_at', 'id', 'created_at'];

                    foreach ($activity->changes['attributes'] as $key => $value) {
                        if (in_array($key, $ignoredFields)) continue;

                        $oldValue = $activity->changes['old'][$key] ?? null;

                        $cleanOld = ($oldValue === null || $oldValue === '') ? null : $oldValue;
                        $cleanNew = ($value === null || $value === '') ? null : $value;

                        if ($cleanOld === $cleanNew) continue;

                        $changes[] = [
                            'label' => str_replace('_', ' ', $key),
                            'old'   => $this->getHumanValue($key, $cleanOld),
                            'new'   => $this->getHumanValue($key, $cleanNew),
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
                if (!$activity->causer_id && $activity->description === 'updated') {
                    return true;
                }
                return false;
            });

        return view('livewire.patient.patient-timeline', ['activities' => $activities]);
    }
}
