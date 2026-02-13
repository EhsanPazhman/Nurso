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
    <div
        class="flex flex-col lg:flex-row gap-4 items-center justify-between bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">

        <div class="flex flex-1 flex-col md:flex-row gap-4 w-full">
            <!-- Search Input -->
            <div class="relative flex-1">
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

            <!-- Status Filter (Hidden when in Trash) -->
            @if (!$showTrashed)
                <div class="w-full md:w-48">
                    <select wire:model.live="status"
                        class="block w-full px-3 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-sm focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="deceased">Deceased</option>
                    </select>
                </div>
            @endif
        </div>

        <!-- Trash Toggle Button -->
        <button wire:click="$set('showTrashed', {{ $showTrashed ? 'false' : 'true' }})"
            class="w-full lg:w-auto flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-xs font-bold transition-all border {{ $showTrashed ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-slate-50 text-slate-500 border-slate-200 hover:bg-slate-100' }} cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            {{ $showTrashed ? 'BACK TO REGISTRY' : 'VIEW TRASH' }}
        </button>
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
                        <th class="px-6 py-4">Gender</th>
                        <th class="px-6 py-4">Phone Number</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/60 transition-colors group">
                            <!-- Name & Code -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                        {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700">{{ $patient->full_name }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono tracking-tighter">
                                            {{ $patient->patient_code }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Father Name -->
                            <td class="px-6 py-4 text-slate-600 font-medium italic">
                                {{ $patient->father_name ?? '---' }}
                            </td>

                            <!-- Gender -->
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-0.5 rounded-lg {{ $patient->gender === 'male' ? 'bg-indigo-50 text-indigo-600' : 'bg-pink-50 text-pink-600' }} text-[10px] font-bold uppercase tracking-wider">
                                    {{ $patient->gender }}
                                </span>
                            </td>

                            <!-- Phone -->
                            <td class="px-6 py-4 text-slate-500">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $patient->phone }}
                                </div>
                            </td>

                            <!-- Status -->
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

                                    {{-- تغییر وضعیت فقط برای بیماران حذف نشده --}}
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
                                            class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-colors cursor-pointer"
                                            title="Restore">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    @else
                                        @can('patient.update')
                                            <a href="{{ route('patient.edit', $patient->id) }}" wire:navigate
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"
                                                title="Edit Patient">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('patient.delete')
                                            <button wire:click="deletePatient({{ $patient->id }})"
                                                wire:confirm="Are you sure you want to permanently delete this patient record?"
                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all cursor-pointer"
                                                title="Delete Patient">
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
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 font-bold">No Records Found</p>
                                    <p class="text-slate-400 text-xs mt-1">There are no patients matching your current
                                        view.</p>
                                </div>
                            </td>
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
