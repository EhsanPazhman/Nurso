<div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 px-6 relative overflow-hidden">
    <!-- Ambient Background Glows -->
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-emerald-600/10 rounded-full blur-[120px] -z-10"></div>

    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-12 h-12 bg-emerald-600 rounded-2xl shadow-2xl shadow-emerald-600/30 mb-4 rotate-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter uppercase italic">Register
                <span class="text-emerald-600 not-italic">Staff</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-[9px] font-bold uppercase tracking-[0.4em] mt-2">
                Administrative Management</p>
        </div>

        <!-- Registration Card -->
        <div
            class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl p-8 rounded-[2.5rem] border border-white/20 dark:border-slate-800/50 shadow-2xl">
            <form wire:submit.prevent="store" class="space-y-5">
                <!-- Full Name Field -->
                <div class="space-y-1.5">
                    <label class="block text-[8px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Personnel
                        Full Name</label>
                    <div class="relative group">
                        <input wire:model.blur='name' type="text"
                            class="w-full bg-slate-100/50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-3.5 pl-11 focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium"
                            placeholder="Dr. Sarah Connor">
                        @error('name')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Email/ID Field -->
                <div class="space-y-1.5">
                    <label class="block text-[8px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Official
                        Email Address</label>
                    <div class="relative group">
                        <input wire:model.blur='email' type="email"
                            class="w-full bg-slate-100/50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-3.5 pl-11 focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium"
                            placeholder="staff@hospital.com">
                        @error('email')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="space-y-1.5">
                    <label class="block text-[8px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Access
                        Level / Role</label>
                    <div class="relative group">
                        <select wire:model.blur='role'
                            class="w-full bg-slate-100/50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-3.5 pl-11 appearance-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium cursor-pointer">
                            <option value="nurse">Clinical Nurse</option>
                            <option value="supervisor">Ward Supervisor</option>
                            <option value="admin">System Administrator</option>
                        </select>
                        @error('role')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Initial Secret Key -->
                <div class="space-y-1.5">
                    <label class="block text-[8px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Temporary
                        Secret Key</label>
                    <div class="relative group">
                        <input wire:model.blur='password' type="password"
                            class="w-full bg-slate-100/50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-3.5 pl-11 focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium"
                            placeholder="••••••••">
                        @error('password')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2a-2 2 0 01-2 2H6a2 2 0 01-2-2v-2m14-4V7a4 4 0 11-8 0v4m8 0a2 2 0 012 2v4a2 2 0 01-2 2M6 11h.01m0 4H6m11-4h.01m0 4H17" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Toggle -->
                <div class="flex items-center px-1">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox"
                            class="w-4 h-4 rounded-lg border-slate-200 dark:border-slate-700 text-emerald-600 focus:ring-0 transition-all">
                        <span
                            class="text-[9px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-700 dark:group-hover:text-slate-300 italic">
                            I confirm this personnel is authorized for HIPAA data access
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-emerald-600 text-white font-black uppercase tracking-[0.3em] text-[9px] py-4 rounded-2xl shadow-xl shadow-emerald-600/20 hover:bg-emerald-700 active:scale-[0.98] transition-all duration-300 flex justify-center items-center gap-3 cursor-pointer">
                    <span wire:loading.remove>Deploy Staff Account</span>
                    <span wire:loading>Processing...</span>
                </button>
            </form>
        </div>

        <!-- Action Link -->
        <div class="text-center mt-6">
            <a href="{{ route('staffs') }}"
                class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-emerald-600 transition-colors">
                ← Return to staffs
            </a>
        </div>
    </div>
</div>
