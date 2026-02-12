<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Manage Bibles<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Bible Versions</h2>
            <p class="mt-1 text-sm text-slate-600">Manage all Bible versions for your API</p>
        </div>
        <a href="<?= base_url('admin/bibleupload') ?>" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Upload New Bible
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-slate-900/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Total Bibles</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1"><?= count($bibles) ?></p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-slate-900/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Active Bibles</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1"><?= count(array_filter($bibles, fn($b) => $b['is_active'])) ?></p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-slate-900/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Languages</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1"><?= count(array_unique(array_column($bibles, 'language'))) ?></p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-slate-900/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Total Size</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1"><?= number_format(array_sum(array_column($bibles, 'file_size')) / 1048576, 1) ?> MB</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Bible List -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Bible</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Language</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Version</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <?php if (empty($bibles)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                    </svg>
                                    <p class="text-slate-500 text-sm">No Bibles found</p>
                                    <a href="<?= base_url('admin/bibleupload') ?>" class="mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">Upload your first Bible →</a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bibles as $bible): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="font-medium text-slate-900"><?= esc($bible['name']) ?></div>
                                        <div class="text-sm text-slate-500"><?= esc($bible['abbreviation']) ?></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?= esc($bible['language']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <?= esc($bible['version'] ?? 'N/A') ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <?= number_format($bible['file_size'] / 1048576, 2) ?> MB
                                </td>
                                <td class="px-6 py-4">
                                    <button 
                                        onclick="toggleStatus(<?= $bible['id'] ?>, this)"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-colors <?= $bible['is_active'] ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-slate-100 text-slate-800 hover:bg-slate-200' ?>"
                                    >
                                        <?= $bible['is_active'] ? 'Active' : 'Inactive' ?>
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="<?= base_url('api/v1/bibles/' . $bible['id'] . '/download') ?>" class="text-blue-600 hover:text-blue-900">Download</a>
                                    <button onclick="confirmDelete(<?= $bible['id'] ?>, '<?= esc($bible['name']) ?>')" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    async function toggleStatus(id, button) {
        const response = await fetch(`<?= base_url('admin/bibles/toggle-status/') ?>${id}`, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (data.is_active) {
                button.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-colors bg-green-100 text-green-800 hover:bg-green-200';
                button.textContent = 'Active';
            } else {
                button.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-colors bg-slate-100 text-slate-800 hover:bg-slate-200';
                button.textContent = 'Inactive';
            }
        }
    }

    function confirmDelete(id, name) {
        if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
            window.location.href = `<?= base_url('admin/bibles/delete/') ?>${id}`;
        }
    }
</script>

<?= $this->endSection() ?>
