<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mt-10">
    <div class="p-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
        <div>
            <h3 class="text-sm font-black text-slate-800 flex items-center gap-2 uppercase tracking-tighter">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Patient Clinical Audit Trail
            </h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Full Activity History</p>
        </div>
    </div>

    <div class="p-10 relative">
        <!-- Vertical Line -->
        <div class="absolute left-[59px] top-10 bottom-10 w-0.5 bg-slate-100"></div>

        <div class="space-y-12">
            @forelse($activities as $activity)
                <div class="relative flex gap-10 group">

                    <!-- Icon Switcher -->
                    <div
                        class="relative z-10 w-12 h-12 rounded-full bg-white border-4 border-white shadow-lg flex items-center justify-center shrink-0 transition-transform group-hover:scale-110 duration-300">
                        @if ($activity->description == 'created')
                            <div
                                class="w-full h-full rounded-full bg-emerald-500 flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                        @elseif($activity->description == 'deleted')
                            <div
                                class="w-full h-full rounded-full bg-rose-500 flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                        @elseif($activity->description == 'restored')
                            <div
                                class="w-full h-full rounded-full bg-blue-600 flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                        @else
                            <div
                                class="w-full h-full rounded-full bg-amber-500 flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Content Box -->
                    <div
                        class="flex-1 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm group-hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-xs font-black text-slate-800 uppercase">
                                    {{ $activity->causer?->name ?? 'Medical System' }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span
                                        class="text-[10px] font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-500 border border-slate-200 uppercase tracking-tighter">
                                        @if ($activity->description == 'created')
                                            Patient Registered
                                        @elseif($activity->description == 'deleted')
                                            Patient Sent to Trash
                                        @elseif($activity->description == 'restored')
                                            Patient Restored to Active Registry
                                        @else
                                            Clinical Data Updated
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span
                                    class="block text-[11px] font-black text-slate-800">{{ $activity->time_formatted }}</span>
                                <span
                                    class="block text-[10px] font-bold text-slate-400 uppercase">{{ $activity->date_formatted }}</span>
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="space-y-3">
                            @if ($activity->description == 'updated' && !empty($activity->custom_changes))
                                @foreach ($activity->custom_changes as $change)
                                    <div
                                        class="flex items-center gap-4 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                                        <span
                                            class="text-[10px] font-black text-slate-400 uppercase w-24 shrink-0">{{ $change['label'] }}</span>
                                        <div class="flex items-center gap-3 flex-1 overflow-hidden">
                                            <span
                                                class="text-[11px] text-slate-400 line-through truncate">{{ $change['old'] }}</span>
                                            <svg class="w-3 h-3 text-blue-300 shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                            <span
                                                class="text-[11px] text-blue-700 font-black truncate">{{ $change['new'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="flex items-center gap-3 text-slate-500 bg-slate-50/50 p-4 rounded-2xl border border-dashed border-slate-200">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-[11px] font-medium italic">
                                        @if ($activity->description == 'created')
                                            This record was successfully established in the hospital registry.
                                        @elseif($activity->description == 'deleted')
                                            Record was moved to the trash bin for safety compliance.
                                        @elseif($activity->description == 'restored')
                                            Record has been successfully recovered and is now active.
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-20 opacity-30">
                    <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-bold uppercase tracking-widest mt-4">No Clinical History Available</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
