<nav class="bg-white shadow-sm ring-1 ring-slate-900/5 mb-8">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo/Brand -->
            <div class="flex items-center gap-x-8">
                <a href="<?= base_url('admin') ?>" class="text-xl font-bold text-slate-900">
                    Bible Admin Panel
                </a>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-x-6">
                    <a href="<?= base_url('admin') ?>" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        Dashboard
                    </a>
                    <a href="<?= base_url('admin/bibleupload') ?>" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        Upload Bible
                    </a>
                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center gap-x-4">
                <span class="text-sm text-slate-600">
                    <?= esc(auth()->user()->email) ?>
                </span>
                <a href="<?= url_to('logout') ?>" 
                   class="inline-flex items-center gap-x-2 rounded-lg bg-slate-100 px-3.5 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-200 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>
