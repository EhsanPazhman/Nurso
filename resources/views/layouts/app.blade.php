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

            <a href="{{ route('dashboard') }}" wire:navigate
                class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-show="isSidebarExpanded" x-cloak x-transition.opacity class="whitespace-nowrap">Dashboard</span>
            </a>

            <p x-show="isSidebarExpanded" x-cloak
                class="mt-6 px-2 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Medical Services
            </p>

            @can('patient.view')
                <a href="{{ route('patients') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('patients.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span x-show="isSidebarExpanded" x-cloak x-transition.opacity class="whitespace-nowrap">Patients</span>
                </a>
            @endcan

            <a href="#"
                class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 transition group">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span x-show="isSidebarExpanded" x-cloak x-transition.opacity
                    class="whitespace-nowrap">Appointments</span>
            </a>

            @can('user.create')
                <a href="{{ route('staffs') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50 hover:text-blue-700 transition-colors group">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span x-show="isSidebarExpanded" x-cloak x-transition.opacity class="whitespace-nowrap">
                        Staffs List</span>
                </a>
            @endcan

            <div class="pt-10">
                <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-rose-600 rounded-lg hover:bg-rose-50 transition group">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span x-show="isSidebarExpanded" x-cloak x-transition.opacity
                        class="whitespace-nowrap">Logout</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Notification System -->
    <div x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="
            message = $event.detail.message;
            type = $event.detail.type || 'success';
            show = true;
            setTimeout(() => show = false, 4000);
        "
        class="fixed top-6 right-6 z-100">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-[-20px]"
            :class="type === 'success' ? 'bg-emerald-600' : 'bg-rose-600'"
            class="text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 font-medium">
            <template x-if="type === 'success'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </template>
            <span x-text="message"></span>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="transition-all duration-300 ease-in-out min-h-screen" :class="isSidebarExpanded ? 'ml-64' : 'ml-20'">
        <!-- Top Utility Bar -->
        <div
            class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 py-3 flex justify-between items-center h-20">
            <div class="flex items-center gap-4">
                <button @click="isSidebarExpanded = !isSidebarExpanded"
                    class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors focus:outline-none cursor-pointer">
                    <svg class="w-6 h-6 transition-transform duration-300"
                        :class="{ 'rotate-180': !isSidebarExpanded }" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
                <!-- عنوان صفحه جاری (اختیاری) -->
                <div class="text-sm font-semibold text-slate-400 uppercase tracking-widest">
                    {{ request()->routeIs('dashboard') ? 'Overview' : 'Medical Registry' }}
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Profile Section -->
                <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-slate-700 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter">
                            {{ auth()->user()->roles->first()->label }}</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-blue-600 border border-blue-700 flex items-center justify-center text-white font-bold shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </div>


        <div class="p-8">
            {{ $slot }}
        </div>
    </main>
</body>

</html>
