<div class="max-w-4xl space-y-8">
    <!-- Page Header -->
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('patients') }}" class="p-2 -ml-2 text-slate-400 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                {{ $patient ? 'Edit Patient File' : 'Register New Patient' }}
            </h1>
        </div>
        <p class="text-sm text-slate-500">Comprehensive patient registry. Fields marked with <span
                class="text-red-500">*</span> are mandatory.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <form wire:submit.prevent="save" class="p-8 space-y-8">

            <!-- Section 1: Basic Information -->
            <div class="space-y-6">
                <h3 class="text-sm font-bold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2">
                    Basic Identity</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">First Name
                            <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="first_name" placeholder="Enter first name"
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('first_name') @else border-slate-200 @enderror rounded-lg focus:border-blue-600 outline-none transition-all">
                        @error('first_name')
                            <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Last Name
                            <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="last_name" placeholder="Enter last name"
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('last_name') @else border-slate-200 @enderror rounded-lg focus:border-blue-600 outline-none transition-all">
                        @error('last_name')
                            <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Father's
                            Name</label>
                        <input type="text" wire:model="father_name" placeholder="Optional"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Gender <span
                                class="text-red-500">*</span></label>
                        <select wire:model="gender"
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('gender') @else border-slate-200 @enderror rounded-lg focus:border-blue-600 outline-none transition-all appearance-none cursor-pointer">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        @error('gender')
                            <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Date of
                            Birth</label>
                        <input type="date" wire:model="date_of_birth"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">National ID
                            (Tazkira)</label>
                        <input type="text" wire:model="national_id" placeholder="ID Number"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 2: Contact & Status -->
            <div class="space-y-6">
                <h3 class="text-sm font-bold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2">
                    Contact & System Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Primary
                            Phone</label>
                        <input type="text" wire:model="phone" placeholder="+93 --- --- ---"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Secondary
                            Phone</label>
                        <input type="text" wire:model="secondary_phone" placeholder="Emergency Contact"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Patient
                            Status <span class="text-red-500">*</span></label>
                        <select wire:model="status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-600 outline-none transition-all cursor-pointer">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="deceased">Deceased</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Home
                        Address</label>
                    <textarea wire:model="address" rows="2" placeholder="Street, District, City..."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-600 outline-none transition-all"></textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <div class="text-[10px] text-slate-400 font-medium italic">
                    All updates are logged with your user ID.
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('patients') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-slate-500 hover:text-slate-700 transition-colors">Cancel</a>
                    <button type="submit" wire:loading.attr="disabled"
                        class="px-10 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition-all flex items-center gap-2">
                        <span wire:loading.remove
                            wire:target="save">{{ $patient ? 'Update File' : 'Register Patient' }}</span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2 italic">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
