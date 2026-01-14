<div class="max-w-6xl mx-auto mt-10 px-4 pb-20">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30 rounded-2xl flex items-center gap-3 transition-all">
            <div class="w-8 h-8 bg-green-500 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-sm font-bold text-green-700 dark:text-green-400 italic">
                {{ session('success') }}
            </p>
        </div>
    @endif
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">Ward Directory</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Manage and
                monitor admitted patients</p>
        </div>

        <div class="flex items-center gap-4">
            <!-- Search Bar -->
            <div class="relative group">
                <input wire:model.live="search" type="text" placeholder="Search by name or bed..."
                    class="w-64 bg-white dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-5 py-3 pl-12 text-sm outline-none focus:border-blue-500 transition-all dark:text-white">
                <div
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <!-- Add Button -->
            <a href="{{ route('patients.create') }}"
                class="bg-blue-600 text-white p-3 rounded-2xl shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div
        class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-2xl overflow-hidden">
        @if ($patients->isEmpty())
            <div class="m-6 text-center text-sm text-slate-500">
                @if (filled($search))
                    No results found for "<strong>{{ $search }}</strong>"
                @else
                    <h1>No patients registered in the system.</h1>
                @endif
            </div>
        @endif

        @foreach ($patients as $patient)
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800">
                        <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Patient / ID
                        </th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Bed</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 font-bold text-xs">
                                    P
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                        {{ $patient->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $patient->age }} |
                                        {{ $patient->gender }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                            <span
                                class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-lg text-xs font-black">
                                #{{ $patient->bed_number }}
                            </span>
                        </td>
                        <td class="p-6">
                            <span
                                class="flex items-center gap-2 text-xs font-bold {{ $patient->status === 'under_observation' ? 'text-amber-500' : ($patient->status === 'discharged' ? 'text-slate-400' : 'text-green-600') }}">
                                <span
                                    class="w-2 h-2 rounded-full {{ $patient->status === 'under_observation' ? 'bg-amber-500' : ($patient->status === 'discharged' ? 'bg-slate-400' : 'bg-green-500 animate-pulse') }}"></span>
                                {{ str($patient->status)->headline() }}
                            </span>
                        </td>
                        <td class="p-6">
                            <div class="flex justify-end gap-2">
                                <!-- Vitals Action -->
                                <a href="{{ route('patients.vitals', $patient->id) }}"
                                    class="p-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 text-blue-600 rounded-xl transition-colors cursor-pointer"
                                    title="Add Vitals">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </a>
                                <!-- Edit Action -->
                                <a href="{{ route('patients.edit', $patient->id) }}"
                                    class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-400 rounded-xl transition-colors"
                                    title="Edit Profile">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <!-- Delete Action -->
                                <button wire:click="deletePatient({{ $patient->id }})"
                                    wire:confirm="Are you sure you want to delete this patient?"
                                    class="p-2 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500 rounded-xl transition-colors cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m-1.022.165a48.11 48.11 0 0 1 3.478-.397" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach

    </div>
    <!-- Pagination -->
    <div class="mt-6">
        {{ $patients->onEachSide(1)->links() }}
    </div>
</div>
