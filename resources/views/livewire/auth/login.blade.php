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
            </div>

            <div>
                <div class="flex justify-between mb-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                    <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">Forgot?</a>
                </div>
                <input wire:model.defer="password" type="password" placeholder="••••••••"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition outline-none">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/10">
                Secure Access
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400">Strictly for authorized personnel only. All access is logged.</p>
        </div>
    </div>
