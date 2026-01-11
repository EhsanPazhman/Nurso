<div class="max-w-4xl mx-auto mt-10 px-4 pb-20">
    <!-- Patient Info Header -->
    <div
        class="bg-white dark:bg-slate-900 rounded-4xl p-8 mb-8 border border-slate-100 dark:border-slate-800 shadow-xl flex justify-between items-center">
        <div>
            <span class="text-blue-500 font-black text-[9px] uppercase tracking-[0.3em]">Monitoring Case</span>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">
                {{ $patient->name }}
            </h2>
        </div>
        <div class="text-right">
            <p class="text-xs font-bold text-slate-400 uppercase">Bed Number</p>
            <p class="text-2xl font-black text-blue-600">#{{ $patient->bed_number }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <!-- Vitals Entry Form -->
        <div class="md:col-span-1 space-y-6">
            <div
                class="bg-white dark:bg-slate-900 rounded-4xl p-6 border border-slate-100 dark:border-slate-800 shadow-lg">
                <h3 class="text-sm font-black uppercase tracking-widest mb-6 text-slate-800 dark:text-slate-200">New
                    Entry</h3>

                <form wire:submit.prevent="save" class="space-y-4">
                    <!-- Temperature -->
                    <div>
                        <label
                            class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1 ml-1">Temp
                            (°C)</label>
                        <input wire:model.blur="temperature" type="number" step="0.1"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl p-3 text-sm focus:border-blue-500 outline-none dark:text-white">
                        @error('temperature')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Heart Rate -->
                    <div>
                        <label
                            class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1 ml-1">Heart
                            Rate (BPM)</label>
                        <input wire:model.blur="heart_rate" type="number"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl p-3 text-sm focus:border-blue-500 outline-none dark:text-white">
                        @error('heart_rate')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Respiratory Rate -->
                    <div>
                        <label
                            class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1 ml-1">Respiratory
                            Rate (BPM)</label>
                        <input wire:model.blur="respiratory_rate" type="number"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl p-3 text-sm focus:border-blue-500 outline-none dark:text-white">
                        @error('respiratory_rate')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Blood Pressure (Systolic / Diastolic) -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label
                                class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1 ml-1">BP
                                (Sys)</label>
                            <input wire:model.blur="blood_pressure_systolic" type="number"
                                class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl p-3 text-sm focus:border-blue-500 outline-none dark:text-white">
                            @error('blood_pressure_systolic')
                                <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1 ml-1">BP
                                (Dia)</label>
                            <input wire:model.blur="blood_pressure_diastolic" type="number"
                                class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl p-3 text-sm focus:border-blue-500 outline-none dark:text-white">
                            @error('blood_pressure_diastolic')
                                <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- SPO2 -->
                    <div>
                        <label
                            class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1 ml-1">SPO2
                            (%)</label>
                        <input wire:model.blur="oxygen_saturation" type="number"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl p-3 text-sm focus:border-blue-500 outline-none dark:text-white">
                        @error('oxygen_saturation')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-black uppercase tracking-widest text-[10px] py-4 rounded-xl shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition-all">
                        Record Vitals
                    </button>
                </form>
            </div>
        </div>

        <!-- Vitals History Chart/List -->
        <div class="md:col-span-2">
            <div
                class="bg-white dark:bg-slate-900 rounded-4xl p-8 border border-slate-100 dark:border-slate-800 shadow-lg h-full">
                <h3 class="text-sm font-black uppercase tracking-widest mb-6 text-slate-800 dark:text-slate-200">Recent
                    Trends</h3>

                <!-- Table of history -->
                <div class="space-y-4">
                    @forelse($history as $vital)
                        <!-- vitals card -->
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                            <div class="grid grid-cols-4 gap-4 flex-1">
                                <div class="text-center">
                                    <p class="text-[8px] uppercase font-bold text-slate-400">Temp</p>
                                    <p class="text-sm font-black dark:text-white">{{ $vital->temperature }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[8px] uppercase font-bold text-slate-400">BPM</p>
                                    <p class="text-sm font-black dark:text-white">{{ $vital->heart_rate }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[8px] uppercase font-bold text-slate-400">BP</p>
                                    <p class="text-sm font-black dark:text-white">
                                        {{ $vital->blood_pressure_systolic }}/{{ $vital->blood_pressure_diastolic }}
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
                            <div class="ml-6 text-right">
                                <p class="text-[9px] font-bold text-slate-400">
                                    {{ $vital->created_at->format('h:i A') }}</p>
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
</div>
