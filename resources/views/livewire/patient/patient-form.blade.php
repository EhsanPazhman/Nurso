<div class="max-w-4xl space-y-8">
    <!-- Page Header -->
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('patients') }}" wire:navigate
                class="p-2 -ml-2 text-slate-400 hover:text-blue-600 transition-colors">
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
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form wire:submit.prevent="save" class="p-8 space-y-12">

            <div class="space-y-6">
                <h3
                    class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em] border-b border-slate-100 pb-3">
                    Basic Identity
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">First Name
                            <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="first_name"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all">
                        @error('first_name')
                            <p class="text-[10px] text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Last Name
                            <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="last_name"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all">
                        @error('last_name')
                            <p class="text-[10px] text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Father's
                            Name <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="father_name"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all">
                        @error('father_name')
                            <p class="text-[10px] text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Gender <span
                                class="text-red-500">*</span></label>
                        <select wire:model="gender"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all cursor-pointer">
                            <option value="">-- Select Gender --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        @error('gender')
                            <p class="text-[10px] text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">National
                            ID</label>
                        <input type="text" wire:model="national_id"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Date of
                            Birth</label>
                        <input type="date" wire:model="date_of_birth"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 2: Contact Information -->
            <div class="space-y-6">
                <h3
                    class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em] border-b border-slate-100 pb-3">
                    Contact Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Primary
                            Phone <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="phone"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all">
                        @error('phone')
                            <p class="text-[10px] text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Secondary
                            Phone</label>
                        <input type="text" wire:model="secondary_phone"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Home
                        Address</label>
                    <textarea wire:model="address" rows="2"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all"></textarea>
                </div>
            </div>

            <!-- Section 3: Clinical Assignment & Status -->
            <div class="space-y-6">
                <h3
                    class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em] border-b border-slate-100 pb-3">
                    Clinical Assignment
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Department
                            <span class="text-red-500">*</span></label>
                        <select wire:model.live="department_id"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all cursor-pointer">
                            <option value="">-- Choose Department --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ (string) $dept->id }}" wire:key="dept-{{ $dept->id }}">
                                    {{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="text-[10px] text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Doctor</label>
                        <select wire:model="doctor_id"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all cursor-pointer">
                            <option value="">-- Optional: Select Doctor --</option>
                            @foreach ($doctors as $doc)
                                <option value="{{ (string) $doc->id }}" wire:key="doc-{{ $doc->id }}">
                                    {{ $doc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-widest">Patient
                            Status <span class="text-red-500">*</span></label>
                        <select wire:model="status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-600 transition-all cursor-pointer">
                            <option value="">-- Select Status --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="deceased">Deceased</option>
                        </select>
                        @error('status')
                            <p class="text-[10px] text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end pt-6 border-t border-slate-100">
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                    {{ $patient ? 'Update Patient Record' : 'Register Patient' }}
                </button>
            </div>
        </form>
    </div>
    @if ($patient && $patient->exists)
        <div class="mt-12 max-w-4xl mx-auto pb-20">
            <livewire:patient.patient-timeline :patientId="$patient->id" wire:key="patient-timeline-{{ $patient->id }}" />
        </div>
    @endif
</div>
