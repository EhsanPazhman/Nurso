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
                    <th class="px-4 py-3">Patient</th>
                    <th class="px-4 py-3">BP</th>
                    <th class="px-4 py-3">Pulse</th>
                    <th class="px-4 py-3">Temp</th>
                    <th class="px-4 py-3">SpO2</th>
                    <th class="px-4 py-3">Res</th>
                    <th class="px-4 py-3">Time</th>
                    <th class="px-4 py-3">Recorded By</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($vitals as $record)
                    {{-- Now $record is a Vital model instance --}}
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="font-bold text-slate-900">{{ $record->patient->full_name }}</div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-[10px] font-mono text-slate-400 italic">#{{ $record->patient->patient_code }}</span>
                                @if (auth()->user()->hasRole(['super_admin', 'hospital_admin']))
                                    <span
                                        class="text-[9px] bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded font-bold uppercase">
                                        {{ $record->patient->department->name ?? 'N/A' }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-4 {{ $record->blood_pressure_color }}">
                            {{ $record->systolic }}/{{ $record->diastolic }}
                        </td>

                        <td class="px-4 py-4 {{ $record->pulse_rate_color }}">
                            {{ $record->pulse_rate }} <span class="text-[10px]">bpm</span>
                        </td>

                        <td class="px-4 py-4 {{ $record->temperature_color }}">
                            {{ $record->temperature }}°C
                        </td>

                        <td class="px-4 py-4 {{ $record->spo2_color }}">
                            {{ $record->spo2 }}%
                        </td>

                        <td class="px-4 py-4 {{ $record->respiration_rate_color }}">
                            {{ $record->respiratory_rate }}
                        </td>

                        <td class="px-4 py-4 text-sm text-slate-600">
                            <div class="font-medium text-slate-900">
                                {{ $record->recorded_at->timezone('Asia/Kabul')->format('h:i A') }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-mono">
                                {{ $record->recorded_at->format('Y-m-d') }}</div>
                        </td>

                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-600 font-bold">
                                    {{ substr($record->user->name, 0, 1) }}
                                </div>
                                <span class="text-xs text-indigo-600 font-semibold">{{ $record->user->name }}</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-20 text-slate-400 italic bg-slate-50/50">
                            <div class="flex flex-col items-center">
                                <svg class="w-8 h-8 mb-2 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                No clinical events recorded in this scope yet.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-slate-50">
            {{ $vitals->links() }}
        </div>
    </div>
</div>
