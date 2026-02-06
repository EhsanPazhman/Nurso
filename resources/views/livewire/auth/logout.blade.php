<div>
    <a href="#" wire:click.prevent="logout"
        class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-rose-600 rounded-lg hover:bg-rose-50 transition group">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span x-show="isSidebarExpanded" x-cloak x-transition.opacity class="whitespace-nowrap">Logout</span>
    </a>
</div>
