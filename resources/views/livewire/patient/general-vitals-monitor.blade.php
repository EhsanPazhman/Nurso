<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-slate-800 italic">Department Clinical Feed</h2>
            <p class="text-xs text-slate-500">Real-time vital signs monitoring for your department.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                    <th class="px-6 py-4">Patient</th>
                    <th class="px-6 py-4">Time</th>
                    <th class="px-6 py-4 text-center">Status Indicators (BP | Pulse | Temp | SpO2)</th>
                    <th class="px-6 py-4">Recorded By</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach ($vitals as $vital)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700">{{ $vital->patient->first_name }}
                                    {{ $vital->patient->last_name }}</span>
                                <span
                                    class="text-[10px] text-slate-400 uppercase font-medium">{{ $vital->patient->patient_code }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 font-medium">
                            {{ $vital->recorded_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-3">
                                <!-- BP -->
                                <div class="px-2 py-1 bg-slate-100 rounded text-[11px] font-bold text-slate-600">
                                    {{ $vital->systolic }}/{{ $vital->diastolic }}
                                </div>
                                <!-- Pulse -->
                                <div
                                    class="px-2 py-1 {{ $vital->pulse_rate > 100 || $vital->pulse_rate < 60 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-50 text-emerald-700' }} rounded text-[11px] font-bold">
                                    {{ $vital->pulse_rate }} <small class="font-normal opacity-70">BPM</small>
                                </div>
                                <!-- Temp -->
                                <div
                                    class="px-2 py-1 {{ $vital->temperature > 37.5 ? 'bg-rose-100 text-rose-700' : 'bg-blue-50 text-blue-700' }} rounded text-[11px] font-bold">
                                    {{ $vital->temperature }}°C
                                </div>
                                <!-- SpO2 -->
                                <div
                                    class="px-2 py-1 {{ $vital->spo2 < 94 ? 'bg-amber-100 text-amber-700' : 'bg-teal-50 text-teal-700' }} rounded text-[11px] font-bold">
                                    {{ $vital->spo2 }}%
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-600 font-medium">{{ $vital->user->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('patient.vitals', $vital->patient_id) }}"
                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-block">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-slate-50">
            {{ $vitals->links() }}
        </div>
    </div>
</div>
