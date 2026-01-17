<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Nurso' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-slate-50 dark:bg-slate-950 transition-colors duration-500">
    <div class="fixed top-6 right-6 z-50 flex flex-col gap-3 w-full max-w-sm">

        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="p-4 bg-emerald-500 text-white rounded-2xl shadow-2xl shadow-emerald-500/20 flex items-center gap-3 border border-emerald-400/20">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-[11px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="p-4 bg-red-500 text-white rounded-2xl shadow-2xl shadow-red-500/20 flex items-center gap-3 border border-red-400/20">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-[11px] font-black uppercase tracking-widest">{{ session('error') }}</p>
            </div>
        @endif

    </div>
    <div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
        <!-- Sidebar Navigation -->
        @auth
            <aside
                class="fixed left-6 top-6 bottom-6 w-24 bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[3rem] border border-white/20 dark:border-slate-800/50 shadow-2xl z-40 flex flex-col items-center py-10 justify-between">

                <!-- Top: Logo -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="w-12 h-12 bg-blue-600 rounded-2xl shadow-lg shadow-blue-600/30 flex items-center justify-center text-white font-black text-xl rotate-3">
                        N
                    </div>
                </div>

                <!-- Middle: Nav Links -->
                <nav class="flex flex-col gap-8">
                    <!-- Dashboard -->
                    <a href="#" class="group relative flex items-center justify-center">
                        <div
                            class="p-4 bg-blue-50 dark:bg-blue-600/10 text-blue-600 rounded-2xl transition-all duration-300 group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                            </svg>
                        </div>
                        <span
                            class="absolute left-20 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Overview</span>
                    </a>

                    <!-- Patients -->
                    <a href="{{ route('patients.index') }}" class="group relative flex items-center justify-center">
                        <div class="p-4 text-slate-400 hover:text-blue-600 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span
                            class="absolute left-20 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Patients</span>
                    </a>

                    <!-- Staff (Registration Link) -->
                    <a href="{{ route('staffs') }}" class="group relative flex items-center justify-center">
                        <div class="p-4 text-slate-400 hover:text-emerald-600 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <span
                            class="absolute left-20 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Staffs</span>
                    </a>
                </nav>

                <!-- Bottom: User & Logout -->
                <div class="flex flex-col gap-6 items-center">
                    <a href="{{ route('logout') }}"
                        class="p-3 text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-2xl transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </div>
            </aside>
        @endauth
        <!-- Main Content Area -->
        <main class="flex-1 ml-32">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>

</html>
