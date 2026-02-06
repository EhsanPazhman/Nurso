<div class="max-w-xl mx-auto mt-20">
    <div class="bg-white p-10 rounded-2xl border border-slate-200 shadow-sm">

        <h1 class="text-2xl font-bold text-slate-800 mb-2">
            Register New Staff
        </h1>
        <p class="text-sm text-slate-500 mb-8">
            Create a new staff account for hospital system access
        </p>

        <form wire:submit.prevent="submit" class="space-y-6">

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Full Name
                </label>
                <input wire:model.defer="name" type="text"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-600/20 outline-none">
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Email
                </label>
                <input wire:model.defer="email" type="email"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-600/20 outline-none">
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Password
                </label>
                <input wire:model.defer="password" type="password"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-600/20 outline-none">
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Role
                </label>
                <select wire:model.defer="role"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-600/20 outline-none">
                    <option value="">Select role</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="hospital_admin">Hospital Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="nurse">Nurse</option>
                    <option value="reception">Reception</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/10 disabled:opacity-70 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="login">
                    Create Staff Account
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
    </div>
</div>
