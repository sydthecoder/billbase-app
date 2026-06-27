<!-- <header>
    <div>
        <p>{{ $title ?? 'Dashboard' }}</p>
    </div>
    <div>
        <p>{{ auth()->user()->first_name }}</p>
    </div>
</header> -->

<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200/60 bg-white/80 px-4 glass-effect lg:px-8 dark:border-dark-border dark:bg-dark-bg/80">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="flex items-center justify-center rounded-xl p-2 text-slate-500 hover:bg-slate-100 lg:hidden dark:text-slate-400 dark:hover:bg-white/5 border">
            <iconify-icon icon="solar:hamburger-menu-linear" width="24" stroke-width="1.5"></iconify-icon>
        </button>

        <div class="hidden md:flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-1.5 ring-1 ring-slate-200 focus-within:ring-brand-500 dark:bg-dark-card dark:ring-dark-border">
            <iconify-icon icon="solar:magnifer-linear" class="text-slate-400"></iconify-icon>
            <input type="text" placeholder="Search analytics..." class="w-64 bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none dark:text-white">
            <div class="flex items-center gap-1 rounded border border-slate-200 px-1.5 py-0.5 dark:border-dark-border">
                <span class="text-xs text-slate-400">⌘K</span>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button id="theme-toggle" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:bg-slate-50 dark:border-dark-border dark:text-slate-400 dark:hover:bg-white/5">
            <iconify-icon id="theme-icon" icon="solar:sun-2-linear" width="20"></iconify-icon>
        </button>

        <button class="relative flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:bg-slate-50 dark:border-dark-border dark:text-slate-400 dark:hover:bg-white/5">
            <iconify-icon icon="solar:bell-linear" width="20"></iconify-icon>
            <span class="absolute right-0 top-0 mr-0.5 mt-0.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-dark-bg"></span>
        </button>
    </div>
</header>