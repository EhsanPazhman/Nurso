<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                {{ $showTrashed ? 'Archived Staff' : 'Staff Directory' }}
            </h1>
            <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest font-semibold">
                {{ $showTrashed ? 'View and restore deleted accounts' : 'Manage hospital personnel and access levels' }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Toggle Trash Button -->
            <button wire:click="toggleTrashView"
                class="px-5 py-3 {{ $showTrashed ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600' }} text-[11px] font-bold uppercase tracking-widest rounded-xl hover:opacity-90 transition-all cursor-pointer">
                {{ $showTrashed ? 'View Active' : 'View Trash' }}
            </button>

            @if (!$showTrashed)
                <a href="{{ route('staff.register') }}" wire:navigate
                    class="px-6 py-3 bg-blue-600 text-white text-[11px] font-bold uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                    Add New Staff
                </a>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search..."
                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-50 transition-all text-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Employee</th>
                    <th class="px-6 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Department</th>
                    <th class="px-6 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Role</th>
                    <th class="px-6 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($staffMembers as $member)
                    <tr class="hover:bg-slate-50/50 transition-colors {{ $member->trashed() ? 'opacity-75' : '' }}">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs">
                                    {{ substr($member->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">{{ $member->name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $member->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span
                                class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-lg uppercase">
                                {{ $member->department?->name ?? 'Global' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex gap-1">
                                @foreach ($member->roles as $role)
                                    <span
                                        class="text-[11px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                        {{ str_replace('_', ' ', $role->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if (!$member->trashed())
                                <button wire:click="toggleStatus({{ $member->id }})" class="flex items-center gap-2">
                                    <div
                                        class="w-2 h-2 rounded-full {{ $member->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                                    </div>
                                    <span
                                        class="text-xs font-medium {{ $member->is_active ? 'text-green-700' : 'text-red-700' }}">
                                        {{ $member->is_active ? 'Active' : 'Suspended' }}
                                    </span>
                                </button>
                            @else
                                <span class="text-[10px] font-bold text-red-400 uppercase">Deleted</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-end items-center gap-3">
                                @if ($showTrashed)
                                    <!-- Restore Button (No Confirmation or Different Message) -->
                                    <button wire:click="restoreStaff({{ $member->id }})"
                                        wire:confirm="Are you sure you want to restore this staff member?"
                                        class="flex items-center gap-1.5 px-4 py-1.5 bg-green-50 text-green-600 rounded-xl hover:bg-green-100 transition-all border border-green-100">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">Restore
                                            Staff</span>
                                    </button>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('staff.edit', $member->id) }}" wire:navigate
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all shadow-sm border border-transparent hover:border-blue-100"
                                        title="Edit Staff">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <!-- Delete Button (With Trash Confirmation) -->
                                    <button wire:click="deleteStaff({{ $member->id }})"
                                        wire:confirm="Are you sure you want to move this staff member to trash?"
                                        class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all shadow-sm border border-transparent hover:border-red-100"
                                        title="Move to Trash">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm italic">No staff members
                            found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
