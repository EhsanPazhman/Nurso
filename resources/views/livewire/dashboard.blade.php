<div class="space-y-8">
    <!-- 1. Dynamic Header based on Role -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                Welcome back, {{ auth()->user()->name }}
                <span class="text-xs font-medium bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full uppercase">
                    {{ auth()->user()->roles->first()->label ?? 'Staff' }}
                </span>
            </h1>
            <p class="text-slate-500 text-sm">Here is what's happening in Nurso Health System today.</p>
        </div>

        <!-- Contextual Quick Actions -->
        <div class="flex items-center gap-3">
            @can('patient.create')
                <a href="{{ route('patient.create') }}" wire:navigate
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Admission
                </a>
            @endcan
        </div>
    </div>

    <!-- 2. Intelligence KPI Section (Adaptive) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @if (auth()->user()->hasRole(['super_admin', 'hospital_admin']))
            <!-- Admin View: Focus on Operations -->
            <x-stats-card title="Total Patients" :value="$totalPatients" icon="users" color="blue" />
            <x-stats-card title="Active Doctors" :value="$activeDoctorsCount" icon="doctor" color="indigo" />
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase mb-2">Hospital Occupancy</p>
                <div class="flex items-end justify-between mb-1">
                    <span class="text-2xl font-bold text-slate-800">{{ $occupancyRate }}%</span>
                    <span class="text-xs text-emerald-500 font-bold">14 Beds Left</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-600 h-full" style="width: {{ $occupancyRate }}%"></div>
                </div>
            </div>
        @else
            <!-- Staff/Nurse View: Focus on Admissions -->
            <x-stats-card title="My Today Admissions" :value="$todayAdmissions" icon="clip" color="emerald" />
            <x-stats-card title="Pending Reports" value="5" icon="document" color="amber" />
        @endif

        <x-stats-card title="System Alerts" value="2" icon="bell" color="rose" />
    </div>

    <!-- 3. Main Operational Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left: Patients (Visible to almost all) -->
        <div class="lg:col-span-2">
            @can('patient.view')
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                        <h2 class="font-bold text-slate-800">Recent Admissions</h2>
                        <a href="{{ route('patients') }}" wire:navigate
                            class="text-xs font-bold text-blue-600 hover:text-blue-800">View Registry</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">Patient Info</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($recentPatients as $patient)
                                    <tr class="hover:bg-slate-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 uppercase">
                                                    {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-slate-700">{{ $patient->full_name }}
                                                    </div>
                                                    <div class="text-[10px] font-mono text-slate-400">
                                                        {{ $patient->patient_code }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $patient->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $patient->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @can('patient.update')
                                                <a href="{{ route('patient.edit', $patient) }}"
                                                    class="opacity-0 group-hover:opacity-100 text-blue-600 hover:text-blue-800 text-xs font-bold transition-opacity">Edit</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-10 text-center text-slate-400 text-sm">No active
                                            patients.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endcan
        </div>

        <!-- Right: Role-Specific Sidebar -->
        <div class="space-y-6">
            <!-- 1. Urgent Shift Notice (Global) -->
            <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-lg shadow-blue-200/20 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-sm font-bold mb-2">Shift Notice</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">System-wide update: Emergency Ward B is now at
                        full capacity. Redirect new trauma cases to Ward C.</p>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>
            </div>

            <!-- 2. Staff on Duty (Visible to Admins) -->
            @if (auth()->user()->hasRole(['super_admin', 'hospital_admin']))
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 tracking-tight">Active Staff Details</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500">Doctors Online:</span>
                            <span class="font-bold text-slate-800">{{ $activeDoctorsCount }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500">Nurses Active:</span>
                            <span class="font-bold text-slate-800">24</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
