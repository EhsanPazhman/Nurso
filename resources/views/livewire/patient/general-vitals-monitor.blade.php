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
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="font-bold text-slate-900">{{ $record->patient->full_name ?? 'Unknown Patient' }}</div>
                            <div class="text-xs text-slate-500">ID: {{ $record->patient->patient_code ?? 'Unknown Patient Code' }}</div>
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

                        <td class="px-4 py-4 {{ $record->respiratory_rate_color }}">
                            {{ $record->respiratory_rate }}
                        </td>

                        <td class="px-4 py-4 text-sm text-slate-600">
                            <div class="font-medium">
                                {{ $record->recorded_at->timezone('Asia/Kabul')->format('h:i A') }}
                            </div>
                            <div class="text-[10px] text-slate-400">{{ $record->recorded_at->format('Y-m-d') }}</div>
                        </td>

                        <td class="px-4 py-4 text-xs text-indigo-600 font-semibold">
                            {{ $record->user->name }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-10 text-slate-400 italic">
                            No clinical data available for this department.
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
