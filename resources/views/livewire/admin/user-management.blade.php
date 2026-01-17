<div class="max-w-6xl mx-auto mt-10 px-4 pb-20">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <div>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter">Staff Directory</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-widest mt-1">Manage
                hospital personnel and hierarchy</p>
        </div>

        <!-- Action Button -->
        <a href="{{ route('user.register') }}"
            class="inline-flex items-center gap-3 bg-emerald-600 text-white px-8 py-4 rounded-3xl font-black uppercase tracking-widest text-[10px] shadow-2xl shadow-emerald-600/30 hover:bg-emerald-700 transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
            Deploy New Staff
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div
        class="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl p-4 rounded-4xl border border-white/20 dark:border-slate-800/50 shadow-xl mb-8 flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <input wire:model.live="search" type="text" placeholder="Search by name, email or role..."
                class="w-full bg-white dark:bg-slate-800 border-none rounded-2xl py-3 pl-12 text-sm focus:ring-2 focus:ring-emerald-500 transition-all dark:text-white">
            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <select wire:model.live="filterRole"
            class="bg-white dark:bg-slate-800 border-none rounded-2xl py-3 px-6 text-sm focus:ring-2 focus:ring-emerald-500 dark:text-white cursor-pointer">
            <option value="">All Roles</option>
            <option value="admin">Administrators</option>
            <option value="supervisor">Supervisors</option>
            <option value="nurse">Nurses</option>
        </select>
    </div>

    <!-- Staff Table -->
    <div
        class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[3rem] border border-white/20 dark:border-slate-800/50 shadow-2xl overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 dark:border-slate-800">
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Personnel
                    </th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Role</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Hierarchy
                        Path</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @foreach ($users as $user)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 tracking-tight">{{ $user->email }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span
                                class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-600' : ($user->role === 'supervisor' ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-600') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <code
                                class="text-[10px] font-mono text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-lg">
                                {{ $user->path }}
                            </code>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('user.edit', $user->id) }}"
                                    class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button wire:confirm="Are you sure you want to delete this staff?"
                                    wire:click="delete({{ $user->id }})"
                                    class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-8 py-6 bg-slate-50/50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800">
            {{ $users->links() }}
        </div>
    </div>
</div>
