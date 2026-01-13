<div class="max-w-6xl mx-auto mt-10 px-4 pb-20">
    <!-- Welcome Header -->
    <div class="mb-12">
        <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter">Clinical Overview</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-widest mt-1">Real-time ward
            statistics and hospital status</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Patients -->
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase text-slate-400">Total Cases</span>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">{{ $patientCount }}</p>
        </div>

        <!-- Critical Cases (SPO2 < 92) -->
        <div
            class="p-6 rounded-[2.5rem] border shadow-xl transition-all duration-500 
    {{ $criticalCaseCount > 0
        ? 'bg-red-50/50 dark:bg-red-900/10 border-red-200 dark:border-red-900/20'
        : 'bg-emerald-50/30 dark:bg-emerald-900/10 border-emerald-100 dark:border-emerald-900/20' }}">

            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors duration-500
            {{ $criticalCaseCount > 0
                ? 'bg-red-100 dark:bg-red-900/40 text-red-600'
                : 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600' }}">

                    @if ($criticalCaseCount > 0)
                        <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                </div>

                <span
                    class="text-[10px] font-black uppercase tracking-wider
            {{ $criticalCaseCount > 0 ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400' }}">
                    {{ $criticalCaseCount > 0 ? 'Critical Alerts' : 'All Patients Safe' }}
                </span>
            </div>

            <p
                class="text-3xl font-black tracking-tight 
        {{ $criticalCaseCount > 0 ? 'text-red-600' : 'text-emerald-700 dark:text-emerald-400' }}">
                {{ $criticalCaseCount }}
            </p>
        </div>

        <!-- Available Beds -->
        <div
            class="p-6 rounded-[2.5rem] border shadow-xl transition-colors duration-500 
    {{ $usagePercent >= 90 ? 'bg-orange-50/50 dark:bg-orange-900/10 border-orange-200 dark:border-orange-800' : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800' }}">

            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 rounded-2xl flex items-center justify-center 
            {{ $usagePercent >= 90 ? 'bg-orange-100 text-orange-600' : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <span
                    class="text-[10px] font-black uppercase {{ $usagePercent >= 90 ? 'text-orange-500' : 'text-slate-400' }}">
                    {{ $usagePercent >= 90 ? 'High Occupancy' : 'Ward Capacity' }}
                </span>
            </div>
            <p
                class="text-3xl font-black tracking-tight {{ $usagePercent >= 90 ? 'text-orange-600' : 'text-slate-900 dark:text-white' }}">
                {{ $usagePercent }}%
            </p>
        </div>


        <!-- New Admissions Today -->
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase text-slate-400">Last 24h</span>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">+{{ $last24HoursAdmissions }}
            </p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="md:col-span-2">
        <div
            class="bg-white dark:bg-slate-900 rounded-4xl p-8 border border-slate-100 dark:border-slate-800 shadow-lg h-full">
            <h3 class="text-sm font-black uppercase tracking-widest mb-6 text-slate-800 dark:text-slate-200">Recent
                Activity...</h3>

            <!-- Table of history -->
            <div class="space-y-4">
                @forelse ($recentVitals as $vital)
                    <div
                        class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <div class="grid grid-cols-5 gap-2 md:gap-4 flex-1 items-center">
                            <div class="text-center border-r border-slate-200 dark:border-slate-700 last:border-0">
                                <p class="text-[8px] uppercase font-bold text-slate-400">Patient</p>
                                <p class="text-xs font-black dark:text-white truncate px-1">{{ $vital->patient->name }}
                                </p>
                            </div>
                            <div class="text-center border-r border-slate-200 dark:border-slate-700 last:border-0">
                                <p class="text-[8px] uppercase font-bold text-slate-400">Temp</p>
                                <p class="text-sm font-black dark:text-white">{{ $vital->temperature }}°</p>
                            </div>
                            <div class="text-center border-r border-slate-200 dark:border-slate-700 last:border-0">
                                <p class="text-[8px] uppercase font-bold text-slate-400">BPM</p>
                                <p class="text-sm font-black dark:text-white">{{ $vital->heart_rate }}</p>
                            </div>
                            <div class="text-center border-r border-slate-200 dark:border-slate-700 last:border-0">
                                <p class="text-[8px] uppercase font-bold text-slate-400">BP</p>
                                <p class="text-sm font-black dark:text-white leading-none">
                                    {{ $vital->blood_pressure_systolic }}<span
                                        class="text-[10px] text-slate-400">/</span>{{ $vital->blood_pressure_diastolic }}
                                </p>
                            </div>
                            <div class="text-center">
                                <p class="text-[8px] uppercase font-bold text-slate-400">SPO2</p>
                                <p
                                    class="text-sm font-black {{ $vital->oxygen_saturation < 92 ? 'text-red-500 animate-pulse' : 'text-blue-600' }}">
                                    {{ $vital->oxygen_saturation }}%
                                </p>
                            </div>
                        </div>
                        <div class="ml-4 text-right shrink-0">
                            <p class="text-[9px] font-bold text-slate-400">{{ $vital->created_at->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center">
                        No vitals history found.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
