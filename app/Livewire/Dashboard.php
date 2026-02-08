<?php

namespace App\Livewire;

use Livewire\Component;
use App\Domains\Patient\Models\Patient;

class Dashboard extends Component
{
    public function mount()
    {
        abort_unless(
            auth()->user()->can('view dashboard'),
            403
        );
    }
    public function render()
    {
        return view('livewire.dashboard', [
            'recentPatients' => auth()->user()->can('patient.view')
                ? Patient::latest()->limit(5)->get()
                : collect(),
        ])->layout('layouts.app');
    }
}
