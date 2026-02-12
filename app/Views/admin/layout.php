<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title', true) ?: 'Admin Panel' ?> - Bible API</title>
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
</head>
<body class="bg-slate-50 antialiased">
    
    <div class="lg:flex lg:h-screen">
        <!-- Sidebar -->
        <aside 
            id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 transform -translate-x-full transition-transform duration-200 lg:translate-x-0 lg:relative lg:flex lg:flex-col"
        >
        <div class="h-full flex flex-col">
            <!-- Logo -->
            <div class="h-16 flex items-center px-6 border-b border-slate-700/50">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <span class="text-lg font-bold text-white">Bible API</span>
                    <p class="text-xs text-slate-400">Admin Panel</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
                <a href="<?= base_url('admin') ?>" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl <?= uri_string() == 'admin' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg <?= uri_string() == 'admin' ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' ?> flex items-center justify-center mr-3 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span>Dashboard</span>
                </a>

                <a href="<?= base_url('admin/bibles') ?>" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl <?= strpos(uri_string(), 'admin/bibles') !== false ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg <?= strpos(uri_string(), 'admin/bibles') !== false ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' ?> flex items-center justify-center mr-3 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <span>Manage Bibles</span>
                </a>

                <a href="<?= base_url('admin/bibleupload') ?>" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl <?= uri_string() == 'admin/bibleupload' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg <?= uri_string() == 'admin/bibleupload' ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' ?> flex items-center justify-center mr-3 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <span>Upload Bible</span>
                </a>

                <div class="pt-4 mt-4 border-t border-slate-700/50">
                    <a href="<?= base_url('admin/generate-token') ?>" class="group w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-xl <?= uri_string() == 'admin/generate-token' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg shadow-emerald-500/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition-all duration-200">
                        <div class="w-9 h-9 rounded-lg <?= uri_string() == 'admin/generate-token' ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-gradient-to-br group-hover:from-emerald-600 group-hover:to-teal-600' ?> flex items-center justify-center mr-3 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <span>Generate API Token</span>
                    </a>
                </div>
            </nav>

            <!-- User Info & Logout -->
            <div class="border-t border-slate-700/50 p-4 bg-slate-900/50">
                <div class="flex items-center mb-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-sm"><?= strtoupper(substr(auth()->user()->email, 0, 2)) ?></span>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate"><?= esc(auth()->user()->username ?? 'Admin') ?></p>
                        <p class="text-xs text-slate-400 truncate"><?= esc(auth()->user()->email) ?></p>
                    </div>
                </div>
                <a href="<?= url_to('logout') ?>" class="group flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-slate-300 bg-slate-800 hover:bg-red-600 rounded-xl hover:text-white transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div 
        id="overlay"
        onclick="toggleSidebar()"
        class="fixed inset-0 bg-slate-900 bg-opacity-50 z-40 lg:hidden hidden"
    ></div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-h-screen lg:overflow-hidden">
        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-0 left-0 right-0 bg-gradient-to-r from-slate-900 to-slate-800 shadow-lg z-30 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mr-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <h1 class="text-lg font-bold text-white">Bible API</h1>
            </div>
            <button onclick="toggleSidebar()" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Top Bar (Desktop) -->
        <header class="hidden lg:block bg-white shadow-sm sticky top-0 z-20">
            <div class="px-6 py-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-900"><?= $this->renderSection('title', true) ?: 'Dashboard' ?></h1>
                <div class="flex items-center gap-x-4">
                    <span class="text-sm text-slate-600"><?= date('l, F j, Y') ?></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-8 mt-16 lg:mt-0">
            <!-- Flash Messages -->
            <?php if (session('success')): ?>
                <div class="mb-6 rounded-lg bg-green-50 p-4 ring-1 ring-green-600/20">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-medium text-green-800"><?= esc(session('success')) ?></p>
                    </div>
                </div>
            <?php endif ?>

            <?php if (session('error')): ?>
                <div class="mb-6 rounded-lg bg-red-50 p-4 ring-1 ring-red-600/20">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-medium text-red-800"><?= esc(session('error')) ?></p>
                    </div>
                </div>
            <?php endif ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
    </div> <!-- End flex container -->

    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

</body>
</html>
