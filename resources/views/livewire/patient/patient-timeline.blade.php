<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
        <div>
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                Activity Timeline & Audit Trail
            </h3>
            <p class="text-[10px] text-slate-500 uppercase tracking-widest mt-1">Clinical history and system logs</p>
        </div>

        @if (auth()->user()->hasRole('super_admin'))
            <button
                class="px-4 py-2 bg-white border border-slate-200 text-[10px] font-bold text-slate-600 rounded-xl hover:bg-slate-50 transition-all uppercase tracking-widest">
                Export Audit Log
            </button>
        @endif
    </div>

    <div class="p-8 relative">
        <div class="absolute left-[47px] top-10 bottom-10 w-0.5 bg-slate-100"></div>

        <div class="space-y-10">
            @forelse($activities as $activity)
                <div class="relative flex gap-6">
                    <div
                        class="relative z-10 w-10 h-10 rounded-full bg-white border-4 border-white shadow-sm flex items-center justify-center">
                        @if ($activity->description == 'created')
                            <div
                                class="w-full h-full rounded-full bg-green-500 flex items-center justify-center text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        @elseif($activity->description == 'deleted')
                            <div
                                class="w-full h-full rounded-full bg-red-500 flex items-center justify-center text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                        @else
                            <div
                                class="w-full h-full rounded-full bg-blue-500 flex items-center justify-center text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div
                        class="flex-1 bg-slate-50/50 rounded-2xl p-5 border border-slate-100 hover:border-blue-200 transition-all">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="text-xs font-black text-slate-800 uppercase tracking-tight">
                                    {{ $activity->causer?->name ?? 'System Process' }}
                                </span>
                                <span
                                    class="ml-2 text-[10px] px-2 py-0.5 rounded-md font-bold uppercase {{ $activity->description == 'created' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $activity->description }}
                                </span>
                            </div>
                            <span
                                class="text-[10px] font-medium text-slate-400 bg-white px-2 py-1 rounded-lg shadow-sm">
                                {{ $activity->created_at->format('Y/m/d - H:i') }}
                            </span>
                        </div>

                        <div class="text-xs text-slate-600 space-y-2">
                            @if ($activity->description == 'updated' && isset($activity->changes['attributes']))
                                @foreach ($activity->changes['attributes'] as $key => $value)
                                    <div
                                        class="flex items-center gap-2 bg-white p-2 rounded-lg border border-slate-50 shadow-sm">
                                        <span
                                            class="font-bold text-slate-500 uppercase text-[9px] w-20">{{ str_replace('_', ' ', $key) }}:</span>
                                        <span
                                            class="text-red-400 line-through decoration-2">{{ $activity->changes['old'][$key] ?? 'None' }}</span>
                                        <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                        <span class="text-blue-700 font-bold capitalize">
                                            @if ($key === 'status')
                                                @if ($value === 'active')
                                                    Active (In-Patient)
                                                @elseif($value === 'inactive')
                                                    Discharged
                                                @elseif($value === 'deceased')
                                                    Deceased
                                                @else
                                                    {{ $value }}
                                                @endif
                                            @elseif($key === 'gender')
                                                {{ $value === 'male' ? 'Male' : 'Female' }}
                                            @elseif($key === 'doctor_id' || $key === 'department_id')
                                                Updated Assignment
                                            @else
                                                {{ $value }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <p class="font-medium">Patient record was {{ $activity->description }} in the system.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-sm text-slate-400 italic">No activity logs found for this patient.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
