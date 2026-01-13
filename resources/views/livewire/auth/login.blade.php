<div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 px-6 relative overflow-hidden">
    <!-- Ambient Background Glows -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px] -z-10"></div>

    <div class="max-w-md w-full">
        <!-- Logo & Branding -->
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-3xl shadow-2xl shadow-blue-600/30 mb-4 rotate-3 hover:rotate-0 transition-transform duration-500">
                <span class="text-white font-black text-2xl">N</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter uppercase italic">Nurso<span
                    class="text-blue-600 not-italic">.</span></h1>
            <p class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-[0.4em] mt-2">Clinical
                Access Point</p>
        </div>

        <!-- Login Card -->
        <div
            class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl p-10 rounded-[3rem] border border-white/20 dark:border-slate-800/50 shadow-2xl">

            <form class="space-y-6">
                <!-- Email Field -->
                <div class="space-y-2">
                    <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Staff ID /
                        Email</label>
                    <div class="relative group">
                        <input type="email"
                            class="w-full bg-slate-100/50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-4 pl-12 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium"
                            placeholder="nurse@nurso.com">
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Secret
                        Key</label>
                    <div class="relative group">
                        <input type="password"
                            class="w-full bg-slate-100/50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-4 pl-12 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium"
                            placeholder="••••••••">
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2a-2 2 0 01-2 2H6a2 2 0 01-2-2v-2m14-4V7a4 4 0 11-8 0v4m8 0a2 2 0 012 2v4a2 2 0 01-2 2M6 11h.01m0 4H6m11-4h.01m0 4H17" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox"
                            class="w-4 h-4 rounded-lg border-slate-200 dark:border-slate-700 text-blue-600 focus:ring-0 transition-all">
                        <span
                            class="text-[10px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-700 dark:group-hover:text-slate-300">Keep
                            me in</span>
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-black uppercase tracking-[0.3em] text-[10px] py-5 rounded-2xl shadow-xl shadow-blue-600/20 hover:bg-blue-700 active:scale-[0.98] transition-all duration-300 flex justify-center items-center gap-3">
                    Authorize Access
                </button>
            </form>
        </div>

        <!-- Footer Note -->
        <p class="text-center mt-8 text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">
            Authorized Personnel Only • Nurso v1.0
        </p>
    </div>
</div>
