<div class="max-w-xl mx-auto mt-20">
    <div class="bg-white p-10 rounded-2xl border border-slate-200 shadow-sm">

        <!-- Dynamic Title -->
        <h1 class="text-2xl font-bold text-slate-800 mb-2">
            {{ $staff ? 'Edit Staff Profile' : 'Register New Staff' }}
        </h1>
        <p class="text-sm text-slate-500 mb-8">
            {{ $staff ? 'Update information for ' . $staff->name : 'Create a new staff account and assign to a clinical department.' }}
        </p>

        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Full Name -->
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest mb-2">Full
                    Name</label>
                <input wire:model="name" type="text" placeholder="e.g. Dr. Ehsan Pazhman"
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
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all cursor-pointer">
                    <option value="">Select department</option>
                    @foreach ($departments as $dept)
                        <option value="{{ (string) $dept->id }}" wire:key="dept-{{ $dept->id }}">{{ $dept->name }}
                        </option>
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
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all cursor-pointer">
                        <option value="">Select role</option>
                        @foreach ($roles as $r)
                            <option value="{{ $r->name }}" wire:key="role-{{ $r->id }}">{{ $r->label }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest mb-2">
                        Password {{ $staff ? '(Optional)' : '' }}
                    </label>
                    <input wire:model="password" type="password" placeholder="********"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-50 focus:border-blue-600 outline-none transition-all">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="{{ route('staffs') }}" wire:navigate
                    class="w-1/3 text-center text-slate-500 font-bold py-3.5 rounded-xl hover:bg-slate-100 transition-all cursor-pointer">
                    Cancel
                </a>
                <button type="submit" wire:loading.attr="disabled"
                    class="w-2/3 bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 disabled:opacity-70 cursor-pointer">
                    <span wire:loading.remove wire:target="submit">
                        {{ $staff ? 'Update Staff Profile' : 'Register Staff Member' }}
                    </span>
                    <span wire:loading wire:target="submit">Processing...</span>
                </button>
            </div>
        </form>
    </div>
</div>
