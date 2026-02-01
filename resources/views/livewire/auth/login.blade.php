    <div class="bg-white p-10 rounded-2xl border border-slate-200 shadow-sm">
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 rounded-xl mb-4 text-white font-bold text-xl">
                N</div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Staff Portal</h1>
            <p class="text-slate-500 text-sm mt-1">Please sign in to your medical account</p>
        </div>

        <form wire:submit.prevent="login" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hospital
                    Email</label>
                <input wire:model.defer="email" type="email" placeholder="dr.pazhman@nerso.com"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition outline-none">
                @error('email')
                    <p class="text-xs text-red-600 font-medium mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between mb-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                    <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">Forgot?</a>
                </div>
                <input wire:model.defer="password" type="password" placeholder="••••••••"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition outline-none">
                @error('password')
                    <p class="text-xs text-red-600 font-medium mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/10 disabled:opacity-70 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="login">
                    Secure Access
                </span>
                <span wire:loading wire:target="login">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Authenticating...
                </span>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400">Strictly for authorized personnel only. All access is logged.</p>
        </div>
    </div>
