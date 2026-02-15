<div class="space-y-8">
    <!-- 1. Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Patients Management</h1>
            <p class="text-sm text-slate-500 mt-1">Total registered patients: <span
                    class="font-bold text-slate-700">{{ $patients->total() }}</span></p>
        </div>

        @can('patient.create')
            <a href="{{ route('patient.create') }}" wire:navigate
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Register New Patient
            </a>
        @endcan
    </div>
    <!-- 2. Search & Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ showFilters: false }">
        <div class="p-4 flex flex-col md:flex-row gap-4 items-center">
            <!-- Main Search -->
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Search by Name, Father, Code or Phone..."
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-sm focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all">
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <!-- Advanced Filters Toggle -->
                <button @click="showFilters = !showFilters"
                    class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 cursor-pointer">
                    <svg class="w-4 h-4" :class="showFilters ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span x-text="showFilters ? 'Hide Filters' : 'Filters'"></span>
                </button>
                <!-- Trash Toggle Button -->
                <button wire:click="$set('showTrashed', {{ $showTrashed ? 'false' : 'true' }})"
                    class="relative group flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition-all border shadow-sm cursor-pointer
    {{ $showTrashed
        ? 'bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100 ring-4 ring-rose-50'
        : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50 hover:border-slate-300' }}">

                    <div class="relative">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        @if ($showTrashed)
                            <span class="absolute -top-1 -right-1 flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-600"></span>
                            </span>
                        @endif
                    </div>

                    <span>{{ $showTrashed ? 'EXIT TRASH BIN' : 'ARCHIVED RECORDS' }}</span>
                </button>
            </div>
        </div>

        <!-- Collapsible Advanced Filters -->
        <div x-show="showFilters" x-collapse x-cloak class="bg-slate-50 border-t border-slate-100 p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Status Filter -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-500 uppercase px-1">Medical Status</label>
                    <select wire:model.live="status"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white text-xs outline-none focus:border-blue-600 transition-all">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="deceased">Deceased</option>
                    </select>
                </div>

                <!-- From Date -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-500 uppercase px-1">Registered From</label>
                    <input type="date" wire:model.live="fromDate"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white text-xs outline-none focus:border-blue-600 transition-all">
                </div>

                <!-- To Date -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-500 uppercase px-1">Registered To</label>
                    <input type="date" wire:model.live="toDate"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white text-xs outline-none focus:border-blue-600 transition-all">
                </div>
            </div>

            <!-- Reset Button -->
            <div class="mt-4 pt-4 border-t border-slate-200 flex justify-end">
                <button wire:click="$set('fromDate', null); $set('toDate', null); $set('status', '');"
                    class="text-[10px] font-bold text-rose-500 hover:text-rose-700 uppercase">Clear All Filters</button>
            </div>
        </div>
    </div>

    <!-- 2. Table Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-6 py-4">Patient & Code</th>
                        <th class="px-6 py-4">Father's Name</th>
                        <th class="px-6 py-4">Assignment (Dept/Doc)</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/60 transition-colors group">
                            <!-- Patient Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                        {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700">{{ $patient->full_name }}</div>
                                        <div class="text-[10px] font-mono text-slate-400 tracking-tighter italic">
                                            {{ $patient->patient_code }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Father Name -->
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                {{ $patient->father_name ?? '---' }}
                            </td>

                            <!-- Assignment: Dept & Doctor (New & Commercial Feature) -->
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-slate-700 uppercase tracking-tight">
                                    {{ $patient->department->name ?? 'Unassigned' }}
                                </div>
                                <div class="text-[10px] text-blue-600 font-medium mt-0.5">
                                    @if ($patient->doctor)
                                        Dr. {{ $patient->doctor->name }}
                                    @else
                                        <span class="text-slate-400 italic font-normal text-[9px]">Waiting for
                                            Physician...</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Phone -->
                            <td class="px-6 py-4 text-slate-500 font-mono text-xs">
                                {{ $patient->phone }}
                            </td>

                            <!-- Status with Toggle -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @php
                                        $statusClasses = [
                                            'active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'inactive' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'deceased' => 'bg-slate-900 text-white border-slate-900',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase {{ $statusClasses[$patient->status] ?? 'bg-slate-50 text-slate-600 border-slate-100' }}">
                                        {{ $patient->status }}
                                    </span>

                                    @if (!$showTrashed)
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open"
                                                class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-cloak
                                                class="absolute left-0 mt-2 w-32 bg-white border border-slate-200 rounded-xl shadow-xl z-50 overflow-hidden">
                                                <button wire:click="changeStatus({{ $patient->id }}, 'active')"
                                                    @click="open = false"
                                                    class="w-full text-left px-4 py-2 text-[10px] font-bold text-emerald-600 hover:bg-emerald-50 border-b border-slate-50">SET
                                                    ACTIVE</button>
                                                <button wire:click="changeStatus({{ $patient->id }}, 'inactive')"
                                                    @click="open = false"
                                                    class="w-full text-left px-4 py-2 text-[10px] font-bold text-amber-600 hover:bg-amber-50 border-b border-slate-50">SET
                                                    INACTIVE</button>
                                                <button wire:click="changeStatus({{ $patient->id }}, 'deceased')"
                                                    @click="open = false"
                                                    class="w-full text-left px-4 py-2 text-[10px] font-bold text-slate-700 hover:bg-slate-100">SET
                                                    DECEASED</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-1">
                                    @if ($showTrashed)
                                        <button wire:click="restorePatient({{ $patient->id }})"
                                            class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-xl transition-all"
                                            title="Restore">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    @else
                                        @can('update', $patient)
                                            <a href="{{ route('patient.edit', $patient->id) }}" wire:navigate
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endcan
                                        @can('delete', $patient)
                                            <button wire:click="deletePatient({{ $patient->id }})"
                                                wire:confirm="Are you sure you want to move this patient to trash?"
                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-slate-400">No matching patient
                                records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Pagination Area -->
    <div class="mt-6">
        {{ $patients->links() }}
    </div>
</div>
