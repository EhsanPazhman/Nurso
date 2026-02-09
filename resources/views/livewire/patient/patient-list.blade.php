<div class="space-y-8">
    <!-- 1. Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Patients Management</h1>
            <p class="text-sm text-slate-500 mt-1">View and manage hospital patient registry</p>
        </div>

        @can('patient.create')
            <a href="{{ route('patient.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Patient
            </a>
        @endcan
    </div>

    <!-- 2. Table Section -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-6 py-4">Patient Information</th>
                        <th class="px-6 py-4">Contact Details</th>
                        <th class="px-6 py-4">Dept</th>
                        <th class="px-6 py-4">Gender</th>
                        <th class="px-6 py-4">Status</th>
                        @can('patient.update')
                            <th class="px-6 py-4 text-right">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ substr($patient->full_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700">{{ $patient->full_name }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono">ID:
                                            {{ $patient->patient_code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $patient->phone }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <span
                                    class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase">{{ $patient->departement ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <span
                                    class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase">{{ $patient->gender }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <span
                                    class="px-2 py-1 rounded text-[10px] font-bold uppercase 
                                    {{ $patient->status === 'active' ? 'bg-green-50 text-green-600' : 'bg-rose-50 text-rose-600' }}">
                                    {{ $patient->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="flex justify-end gap-2 opacity-100 group-hover:opacity-100 transition-opacity">
                                    @can('patient.update')
                                        <a href="{{ route('patient.edit', $patient->id) }}"
                                            class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit Patient">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    @endcan

                                    @can('patient.delete')
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                            title="Delete Patient">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-200 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-slate-400 font-medium">No patients found in registry</p>
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
