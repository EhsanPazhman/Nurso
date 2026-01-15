<div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 px-6 relative overflow-hidden">
    <!-- Ambient Background Glows -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px] -z-10"></div>

    <div class="max-w-md w-full">
        <!-- Logo & Branding -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 rounded-2xl shadow-2xl shadow-blue-600/30 mb-4 rotate-3 hover:rotate-0 transition-transform duration-500">
                <span class="text-white font-black text-xl">N</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter uppercase italic">Nurso<span
                    class="text-blue-600 not-italic">.</span></h1>
            <p class="text-slate-500 dark:text-slate-400 text-[9px] font-bold uppercase tracking-[0.4em] mt-2">Secure
                Clinical Gateway</p>
        </div>

        <!-- Login Card -->
        <div
            class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl p-8 rounded-[2.5rem] border border-white/20 dark:border-slate-800/50 shadow-2xl">
            <form wire:submit.prevent='login' class="space-y-5">
                <!-- Identification Field -->
                <div class="space-y-1.5">
                    <label class="block text-[8px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Staff
                        Credentials</label>
                    <div class="relative group">
                        <input wire:model.blur="email" type="email"
                            class="w-full bg-slate-100/50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-3.5 pl-11 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium"
                            placeholder="Your work email">
                        @error('email')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Secret Key Field -->
                <div class="space-y-1.5">
                    <label
                        class="block text-[8px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Password</label>
                    <div class="relative group">
                        <input wire:model.blur="password" type="password"
                            class="w-full bg-slate-100/50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-3.5 pl-11 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium"
                            placeholder="••••••••">
                        @error('password')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2a-2 2 0 01-2 2H6a2 2 0 01-2-2v-2m14-4V7a4 4 0 11-8 0v4m8 0a2 2 0 012 2v4a2 2 0 01-2 2M6 11h.01m0 4H6m11-4h.01m0 4H17" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Remember & Security Options -->
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input wire:model="remember" type="checkbox"
                            class="w-3.5 h-3.5 rounded-md border-slate-200 dark:border-slate-700 text-blue-600 focus:ring-0 transition-all">
                        <span
                            class="text-[9px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-700 dark:group-hover:text-slate-300">Trust
                            Device</span>
                    </label>
                    <a href="#"
                        class="text-[9px] font-bold text-blue-600 uppercase tracking-widest hover:text-blue-700 transition-colors">Reset
                        Key</a>
                </div>

                <!-- Action Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-black uppercase tracking-[0.3em] text-[9px] py-4 rounded-2xl shadow-xl shadow-blue-600/20 hover:bg-blue-700 active:scale-[0.98] transition-all duration-300 flex justify-center items-center gap-3">
                    Authenticate Access
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 flex flex-col items-center gap-2">
            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                Standard Operating Procedure • HIPAA Compliant
            </p>
            <div class="flex gap-4">
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
            </div>
        </div>
    </div>
</div>
