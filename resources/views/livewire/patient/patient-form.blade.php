<!-- Container -->
<div class="max-w-2xl mx-auto mt-10 px-4">
    <!-- Card Frame -->
    <div
        class="bg-white dark:bg-slate-900 shadow-2xl rounded-[2.5rem] border border-slate-100 dark:border-slate-800 overflow-hidden">

        <!-- Aesthetic Header -->
        <div class="bg-linear-to-r from-blue-600 to-indigo-600 p-10">
            <div class="flex items-center gap-5">
                <div
                    class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-xl border border-white/30">
                    <!-- Icon Placeholder -->
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight">Patient Admission</h2>
                    <p class="text-blue-100/80 text-[10px] font-bold uppercase tracking-[0.2em]">Clinical Information
                        System</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-10">
            <form wire:submit.prevent="save">
                <div class="grid md:grid-cols-2 gap-8">

                    <!-- Full Name Field -->
                    <div class="col-span-2 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 ml-1">Full
                            Identity</label>
                        <input wire:model.blur="name" type="text" placeholder="Enter patient full name..."
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-4 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium">
                        @error('name')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Age Field -->
                    <div class="space-y-2">
                        <label
                            class="block text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 ml-1">Age</label>
                        <input wire:model.blur="age" type="number"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-4 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium">
                        @error('age')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Bed Number Field -->
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 ml-1">Bed
                            Number</label>
                        <input wire:model.blur="bed_number" type="number"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-4 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-800 transition-all outline-none dark:text-white text-sm font-medium">
                        @error('bed_number')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Gender Select -->
                    <div class="space-y-2">
                        <label
                            class="block text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 ml-1">Gender</label>
                        <select wire:model.blur="gender"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-4 focus:border-blue-500 outline-none dark:text-white text-sm font-medium appearance-none">
                            <option value="" disabled> Select Gender </option>
                            @foreach ($genders as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('gender')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status Select -->
                    <div class="space-y-2">
                        <label
                            class="block text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 ml-1">Admission
                            Status</label>
                        <select wire:model.blur="status"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-transparent rounded-2xl p-4 focus:border-blue-500 outline-none dark:text-white text-sm font-medium appearance-none">
                            <option value="" disabled>Select Status</option>
                            @foreach ($statuses as $statusKey => $statusLabel)
                                <option value="{{ $statusKey }}">{{ $statusLabel }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Action Button -->
                <div class="mt-10">
                    <button
                        class="w-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-black uppercase tracking-[0.3em] text-[10px] py-5 rounded-2xl hover:bg-blue-600 dark:hover:bg-blue-600 dark:hover:text-white transition-all duration-300 shadow-xl active:scale-[0.98] cursor-pointer">
                        {{ $patientId ? 'Update Patient' : 'Register Patient' }}
                    </button>
            </form>
        </div>
    </div>
</div>
</div>
