<dive>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">System Dashboard</h1>
        <p class="text-slate-500 text-sm">Overview of current hospital facility status and active staff.</p>
    </div>

    <!-- KPI Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card Item -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Total Patients</p>
                <p class="text-2xl font-bold text-slate-800">1,204</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Admissions Today</p>
                <p class="text-2xl font-bold text-slate-800">48</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Doctors Active</p>
                <p class="text-2xl font-bold text-slate-800">12</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Beds Available</p>
                <p class="text-2xl font-bold text-slate-800">14</p>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Patients Table -->
        @can('patient.view')
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h2 class="font-bold text-slate-800 tracking-tight">Recent Patient Admissions</h2>
                        <a href="{{ route('patients') }}"
                            class="text-xs font-semibold text-blue-600 hover:text-blue-700">View All</a>
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-6 py-3 border-b border-slate-100">Patient</th>
                                <th class="px-6 py-3 border-b border-slate-100">ID</th>
                                <th class="px-6 py-3 border-b border-slate-100">Dept</th>
                                <th class="px-6 py-3 border-b border-slate-100">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100">
                            @forelse ($recentPatients as $patient)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-700 text-sm">{{ $patient->full_name }}</div>
                                        <div class="text-xs text-slate-400">{{ $patient->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 font-mono">{{ $patient->patient_code }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $patient->department ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 rounded text-[10px] font-bold uppercase 
                                    {{ $patient->status === 'active' ? 'bg-green-50 text-green-600' : 'bg-rose-50 text-rose-600' }}">
                                            {{ $patient->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                        No Patient Found!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan

        <!-- Right Side: Sidebar Widgets -->
        <div class="space-y-6">
            <!-- Notices Widget -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                    Shift Notifications
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                        <p class="text-xs font-bold text-slate-600 uppercase mb-1">Blood Bank</p>
                        <p class="text-sm text-slate-500">Low stock level: O Negative. Supply required in Ward A.</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                        <p class="text-xs font-bold text-slate-600 uppercase mb-1">Facility</p>
                        <p class="text-sm text-slate-500">Elevator B is scheduled for maintenance at 14:00.</p>
                    </div>
                </div>
            </div>

            <!-- Active Appointments -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800">Next Appointments</h3>
                </div>
                <div class="p-0">
                    <div class="p-4 border-b border-slate-50 flex items-center gap-4">
                        <div class="text-center">
                            <span class="block text-xs font-bold text-blue-600 uppercase">10:30</span>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase">AM</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-700">Consultation</p>
                            <p class="text-xs text-slate-400 truncate w-32">Dr. Mark Wood</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</dive>
