<div class="max-w-xl mx-auto mt-20">
    <div class="bg-white p-10 rounded-2xl border border-slate-200 shadow-sm">

        <h1 class="text-2xl font-bold text-slate-800 mb-2">Register New Staff</h1>
        <p class="text-sm text-slate-500 mb-8">Create a new staff account and assign to a clinical department.</p>

        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Full Name -->
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest mb-2 text-wrap">Full
                    Name</label>
                <input wire:model="name" type="text" placeholder="ٍe.g. Dr. Ehsan Pazhman"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all">
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest mb-2">Email
                    Address</label>
                <input wire:model="email" type="email" placeholder="staff@nurso.com"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all">
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Department Assignment -->
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest mb-2">Assign
                    Department</label>
                <select wire:model="department_id"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Select department</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Role -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest mb-2">System
                        Role</label>
                    <select wire:model="role"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all appearance-none cursor-pointer">
                        <option value="">Select role</option>
                        @foreach ($roles as $r)
                            <option value="{{ $r->name }}">{{ $r->label }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label
                        class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest mb-2">Password</label>
                    <input wire:model="password" type="password" placeholder="********"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <!-- Back Button -->
                <a href="{{ route('staffs') }}" wire:navigate
                    class="w-full bg-rose-600 text-white font-bold py-3.5 rounded-xl hover:bg-rose-700 transition-all shadow-lg shadow-blue-200 disabled:opacity-70 cursor-pointer">
                    <span class="flex items-center justify-center gap-2">Cancel & Return</span>
                </a>
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 disabled:opacity-70 cursor-pointer">
                    <span wire:loading.remove wire:target="submit">Register Staff Member</span>
                    <span wire:loading wire:target="submit" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
