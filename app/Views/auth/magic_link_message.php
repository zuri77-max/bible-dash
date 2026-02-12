<?= $this->extend('App\Views\auth\layout') ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <!-- Success Icon -->
    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
        <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
        </svg>
    </div>

    <!-- Message Card -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-8 text-center">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900 mb-4">
            Check your email
        </h2>
        
        <p class="text-base text-slate-600 mb-6">
            We've sent a magic link to
            <span class="font-medium text-slate-900"><?= esc($email ?? 'your email') ?></span>
        </p>

        <div class="rounded-lg bg-slate-50 p-4 mb-6">
            <p class="text-sm text-slate-700">
                Click the link in the email to sign in to your admin account. The link will expire in 1 hour.
            </p>
        </div>

        <div class="space-y-3">
            <p class="text-xs text-slate-500">
                Didn't receive the email? Check your spam folder.
            </p>
            <a href="<?= url_to('login') ?>" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                ← Return to login
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
