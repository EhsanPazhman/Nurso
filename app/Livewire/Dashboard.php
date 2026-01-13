<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\Vital;
use Livewire\Component;

class Dashboard extends Component
{
    public $patientCount;
    public $criticalCaseCount;
    public $wardCapacity = 20; 
    public $usagePercent = 0;
    public $last24HoursAdmissions;
    public $recentVitals;

    public function mount()
    {
        $this->patientCount = Patient::where('status', '!=', 'discharged')->count();
        $this->criticalCaseCount = Vital::where('oxygen_saturation', '<', 92)
            ->where('created_at', '>=', now()->subHours(12))
            ->distinct('patient_id')
            ->count();

        $this->last24HoursAdmissions = Patient::where('created_at', '>=', now()->subDay())->count();

        $this->usagePercent = $this->wardCapacity > 0
            ? min(round(($this->patientCount / $this->wardCapacity) * 100, 1), 100)
            : 0;

        $this->recentVitals = Vital::with('patient')
            ->latest()
            ->take(8)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
