<div class="p-3 bg-slate-50 min-h-screen">
    <div class="w-full">
        <div class="grid grid-cols-12 gap-4 items-start">

            <!-- Quick Entry Section (Left Side) -->
            <div
                class="col-span-12 xl:col-span-7 bg-white rounded-2xl shadow-lg border border-slate-200 sticky top-4 h-fit">
                <div class="p-5">

                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">
                                Clinical Observation
                            </h2>
                            <p class="text-sm text-slate-500">
                                Patient:
                                <span class="font-semibold text-slate-700">
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </span>
                            </p>
                        </div>

                        <a href="{{ route('patients') }}"
                            class="px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">
                            ← Back
                        </a>
                    </div>

                    <form wire:submit.prevent="save" class="divide-y divide-slate-100">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-6">

                            <!-- Cardiovascular -->
                            <div class="space-y-5">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Cardiovascular
                                </h4>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label class="text-xs font-medium text-slate-500">BP Systolic</label>
                                        <div class="relative">
                                            <input type="number" wire:model="systolic" placeholder="120"
                                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium">
                                            <span
                                                class="absolute right-3 top-2.5 text-[10px] text-slate-400">mmHg</span>
                                        </div>
                                        @error('systolic')
                                            <span class="text-rose-500 text-[11px]">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-medium text-slate-500">BP Diastolic</label>
                                        <div class="relative">
                                            <input type="number" wire:model="diastolic" placeholder="80"
                                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium">
                                            <span
                                                class="absolute right-3 top-2.5 text-[10px] text-slate-400">mmHg</span>
                                        </div>
                                        @error('diastolic')
                                            <span class="text-rose-500 text-[11px]">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-slate-500">Pulse Rate</label>
                                    <div class="relative">
                                        <input type="number" wire:model="pulse_rate" placeholder="72"
                                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium">
                                        <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">BPM</span>
                                    </div>
                                    @error('pulse_rate')
                                        <span class="text-rose-500 text-[11px]">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Respiratory -->
                            <div class="space-y-5 lg:border-x lg:px-6 border-slate-100">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Respiratory & Temp
                                </h4>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label class="text-xs font-medium text-slate-500">SpO2</label>
                                        <div class="relative">
                                            <input type="number" wire:model="spo2" placeholder="98"
                                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium">
                                            <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">%</span>
                                        </div>
                                        @error('spo2')
                                            <span class="text-rose-500 text-[11px]">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-medium text-slate-500">Respiration</label>
                                        <div class="relative">
                                            <input type="number" wire:model="respiratory_rate" placeholder="16"
                                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium">
                                            <span
                                                class="absolute right-3 top-2.5 text-[10px] text-slate-400">/min</span>
                                        </div>
                                        @error('respiratory_rate')
                                            <span class="text-rose-500 text-[11px]">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label class="text-xs font-medium text-slate-500">Temperature</label>
                                        <div class="relative">
                                            <input type="number" step="0.1" wire:model="temperature"
                                                placeholder="36.5"
                                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium">
                                            <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">°C</span>
                                        </div>
                                        @error('temperature')
                                            <span class="text-rose-500 text-[11px]">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-medium text-slate-500">Weight</label>
                                        <div class="relative">
                                            <input type="number" step="0.1" wire:model="weight" placeholder="70"
                                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium">
                                            <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">Kg</span>
                                        </div>
                                        @error('weight')
                                            <span class="text-rose-500 text-[11px]">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Log Details -->
                            <div class="space-y-5">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Log Details
                                </h4>

                                <div>
                                    <label class="text-xs font-medium text-slate-500">Observation Time</label>
                                    <input type="datetime-local" wire:model="recorded_at"
                                        value="{{ now()->setTimezone('Asia/Kabul')->format('Y-m-d\TH:i') }}"
                                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium">
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-slate-500">Nursing Notes</label>
                                    <textarea wire:model="nursing_note" rows="3"
                                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-base font-medium resize-none"></textarea>
                                    @error('nursing_note')
                                        <span class="text-rose-500 text-[11px]">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Submit -->
                        <div class="pt-4 flex justify-end">
                            <button type="submit"
                                class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                Submit Vitals
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- Clinical History Section -->
            <div
                class="col-span-12 xl:col-span-5 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-700">
                        Clinical Trends: {{ $patient->first_name }}
                    </h3>
                    <span
                        class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-bold uppercase tracking-wider">
                        Latest 10 Logs
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-400 font-bold uppercase italic">
                            <tr>
                                <th class="px-4 py-3">Time</th>
                                <th class="px-4 py-3">BP</th>
                                <th class="px-4 py-3">Pulse</th>
                                <th class="px-4 py-3">Temp</th>
                                <th class="px-4 py-3">SpO2</th>
                                <th class="px-4 py-3">Res</th>
                                <th class="px-4 py-3">Staff</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($vitalsHistory as $history)
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="px-4 py-3 text-slate-500 font-medium">
                                        {{ $history->recorded_at->timezone('Asia/Kabul')->format('M d, H:i') }}
                                    </td>
                                    <td class="px-4 py-3 {{ $history->blood_pressure_color }}">
                                        {{ $history->systolic }}/{{ $history->diastolic }}
                                    </td>
                                    <td class="px-4 py-3 {{ $history->temperature_color }}">
                                        {{ $history->temperature }}°C
                                    </td>
                                    <td class="px-4 py-3 {{ $history->pulse_rate_color }}">
                                        {{ $history->pulse_rate }}
                                    </td>
                                    <td class="px-4 py-3 {{ $history->spo2_color }}">
                                        {{ $history->spo2 }}%
                                    </td>
                                    <td class="px-4 py-3 {{ $history->respiratory_rate_color }}">
                                        {{ $history->respiratory_rate }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-400 italic font-medium">
                                        {{ $history->user->name }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400 italic font-light">
                                        No clinical records found for this patient.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
