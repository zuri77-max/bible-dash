<?= $this->extend('App\Views\auth\layout') ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <!-- Logo/Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">
            Bible API Admin
        </h1>
        <p class="mt-2 text-sm text-slate-600">
            Sign in to manage your Bible API
        </p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-8">
        <?php if (session('error') !== null) : ?>
            <div class="mb-6 rounded-lg bg-red-50 p-4 ring-1 ring-inset ring-red-600/10">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            <?= esc(session('error')) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php if (session('message') !== null) : ?>
            <div class="mb-6 rounded-lg bg-blue-50 p-4 ring-1 ring-inset ring-blue-600/10">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-800">
                            <?= esc(session('message')) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <form action="<?= url_to('login') ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-slate-900">
                    Email address
                </label>
                <div class="mt-2">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="<?= old('email') ?>"
                        required 
                        autofocus
                        autocomplete="email"
                        class="block w-full rounded-lg border-0 px-3.5 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 focus:outline-none sm:text-sm sm:leading-6 transition-shadow"
                        placeholder="admin@example.com"
                    >
                </div>
                <?php if (session('errors.email')) : ?>
                    <p class="mt-2 text-sm text-red-600">
                        <?= esc(session('errors.email')) ?>
                    </p>
                <?php endif ?>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium leading-6 text-slate-900">
                    Password
                </label>
                <div class="mt-2">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        autocomplete="current-password"
                        class="block w-full rounded-lg border-0 px-3.5 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 focus:outline-none sm:text-sm sm:leading-6 transition-shadow"
                        placeholder="••••••••"
                    >
                </div>
                <?php if (session('errors.password')) : ?>
                    <p class="mt-2 text-sm text-red-600">
                        <?= esc(session('errors.password')) ?>
                    </p>
                <?php endif ?>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox" 
                        <?php if (old('remember')) : ?>checked<?php endif ?>
                        class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600 focus:ring-offset-0 transition-colors cursor-pointer"
                    >
                    <label for="remember" class="ml-2 block text-sm text-slate-700 cursor-pointer">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="<?= url_to('magic-link') ?>" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                        Use a login link
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit"
                    class="w-full flex justify-center items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-colors"
                >
                    Sign in
                </button>
            </div>
        </form>
    </div>

    <!-- Footer Text -->
    <p class="text-center text-xs text-slate-500">
        Admin access only • Protected by Shield
    </p>
</div>
<?= $this->endSection() ?>
