<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerso HMS - Professional Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="h-full antialiased text-slate-900" x-data="{ isSidebarExpanded: true }">

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 bg-white border-r border-slate-200 z-50 transition-all duration-300 ease-in-out overflow-y-auto overflow-x-hidden"
        :class="isSidebarExpanded ? 'w-64' : 'w-20'">
        <!-- Logo Area -->
        <div class="p-6 h-20 flex items-center">
            <div class="flex items-center gap-3 text-blue-600 font-bold text-2xl tracking-tight">
                <div class="min-w-8 h-8 bg-blue-600 rounded flex items-center justify-center shrink-0">
                    <span class="text-white text-xs font-bold">N</span>
                </div>
                <span x-show="isSidebarExpanded" x-cloak x-transition.opacity>NERSO</span>
            </div>
        </div>

        <nav class="mt-2 px-4 pb-4 space-y-1">
            <!-- Nav Group: Core -->
            <p x-show="isSidebarExpanded" x-cloak
                class="px-2 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">General</p>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg bg-blue-50 text-blue-700 group">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-show="isSidebarExpanded" x-cloak x-transition.opacity class="whitespace-nowrap">Dashboard</span>
            </a>

            <p x-show="isSidebarExpanded" x-cloak
                class="mt-6 px-2 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Medical Services
            </p>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 transition group">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span x-show="isSidebarExpanded" x-cloak x-transition.opacity class="whitespace-nowrap">Patients</span>
            </a>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 transition group">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span x-show="isSidebarExpanded" x-cloak x-transition.opacity
                    class="whitespace-nowrap">Appointments</span>
            </a>

            <div class="pt-10">
                <livewire:auth.logout />
            </div>
        </nav>
    </aside>
    {{-- SESSION (after redirect) --}}
    @if (session()->has('notify'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-cloak class="fixed top-6 right-6 z-50">
            <div class="text-white px-6 py-3 rounded-xl shadow-lg bg-emerald-800">
                {{ session('notify.message') }}
            </div>
        </div>
    @endif
    {{-- LIVEWIRE (redirect) --}}
    <div x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="
        message = $event.detail.message;
        type = $event.detail.type;
        show = true;
        setTimeout(() => show = false, 3000);
    ">
        <template x-if="show">
            <div class="fixed top-6 right-6 z-50">
                <div :class="type === 'success' ? 'bg-emerald-500' : 'bg-red-500'"
                    class="text-white px-6 py-3 rounded-xl shadow-lg">
                    <span x-text="message"></span>
                </div>
            </div>
        </template>
    </div>

    <!-- Main Content Area -->
    <main class="transition-all duration-300 ease-in-out min-h-screen" :class="isSidebarExpanded ? 'ml-64' : 'ml-20'">
        <!-- Top Utility Bar -->
        <div
            class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 py-3 flex justify-between items-center h-20">
            <div class="flex items-center gap-4">
                <!-- Toggle Button -->
                <button @click="isSidebarExpanded = !isSidebarExpanded"
                    class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors focus:outline-none  cursor-pointer">
                    <svg class="w-6 h-6 transition-transform duration-300" :class="{ 'rotate-180': !isSidebarExpanded }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
                <div class="text-sm font-medium text-slate-500">Welcome back, Dr. Arash</div>
            </div>

            <div class="flex items-center gap-4">
                <button class="p-2 text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300"></div>
            </div>
        </div>

        <div class="p-8">
            {{ $slot }}
        </div>
    </main>

</body>

</html>
