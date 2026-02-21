<div class="p-6 min-h-screen bg-slate-50">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Clinical Observation</h2>
                <p class="text-sm text-slate-500">Patient: <span
                        class="font-semibold text-slate-700">{{ $patient->first_name }} {{ $patient->last_name }}</span>
                </p>
            </div>
            <a href="{{ route('patients') }}"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">
                ← Back to List
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <form wire:submit.prevent="save" class="divide-y divide-slate-100">
                <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="space-y-6">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Cardiovascular</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-slate-500">BP Systolic</label>
                                <div class="relative">
                                    <input type="number" wire:model="systolic" placeholder="120"
                                        class="w-full pl-3 pr-10 py-2.5 bg-slate-50 border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">mmHg</span>
                                </div>
                                @error('systolic')
                                    <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-slate-500">BP Diastolic</label>
                                <div class="relative">
                                    <input type="number" wire:model="diastolic" placeholder="80"
                                        class="w-full pl-3 pr-10 py-2.5 bg-slate-50 border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">mmHg</span>
                                </div>
                                @error('diastolic')
                                    <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-500">Pulse Rate (Heartbeat)</label>
                            <div class="relative">
                                <input type="number" wire:model="pulse_rate" placeholder="72"
                                    class="w-full pl-3 pr-10 py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm">
                                <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">BPM</span>
                            </div>
                            @error('pulse_rate')
                                <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="space-y-6 lg:border-x lg:px-8 border-slate-100">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Respiratory & Temp</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-slate-500">SpO2</label>
                                <div class="relative">
                                    <input type="number" wire:model="spo2" placeholder="98"
                                        class="w-full pl-3 pr-10 py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm">
                                    <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">%</span>
                                </div>
                                @error('spo2')
                                    <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-slate-500">Respiration</label>
                                <div class="relative">
                                    <input type="number" wire:model="respiratory_rate" placeholder="16"
                                        class="w-full pl-3 pr-10 py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm">
                                    <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">/min</span>
                                </div>
                                @error('respiratory_rate')
                                    <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-slate-500">Temperature</label>
                                <div class="relative">
                                    <input type="number" step="0.1" wire:model="temperature" placeholder="36.5"
                                        class="w-full pl-3 pr-10 py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm">
                                    <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">°C</span>
                                </div>
                                @error('temperature')
                                    <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-slate-500">Weight</label>
                                <div class="relative">
                                    <input type="number" step="0.1" wire:model="weight" placeholder="70"
                                        class="w-full pl-3 pr-10 py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm">
                                    <span class="absolute right-3 top-2.5 text-[10px] text-slate-400">Kg</span>
                                </div>
                                @error('weight')
                                    <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Log Details</h4>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-500">Observation Time</label>
                            <input type="datetime-local" wire:model="recorded_at"
                                class="w-full px-3 py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-500">Nursing Notes</label>
                            <textarea wire:model="nursing_note" rows="3" placeholder="Any clinical observations..."
                                class="w-full px-3 py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm resize-none"></textarea>
                            @error('nursing_note')
                                <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="p-6 bg-slate-50/50 flex justify-end">
                    <button type="submit"
                        class="px-10 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 flex items-center gap-2 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Submit Vitals
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
