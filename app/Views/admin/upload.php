<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Upload Bible<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Upload Bible File</h2>
                <p class="text-sm text-slate-600">Upload a JSON formatted Bible file</p>
            </div>
        </div>

        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-medium mb-1">File Format Requirements:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        <li>Only JSON files (.json) are accepted</li>
                        <li>File must contain valid Bible data structure</li>
                        <li>Maximum file size: 50MB</li>
                    </ul>
                </div>
            </div>
        </div>

        <form id="uploadForm" action="<?= base_url('admin/bibleupload/upload') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Bible Name
                </label>
                <input 
                    type="text" 
                    name="bible_name"
                    placeholder="e.g., King James Version"
                    required
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Language
                </label>
                <input 
                    type="text" 
                    name="language"
                    placeholder="e.g., English"
                    required
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Abbreviation
                </label>
                <input 
                    type="text" 
                    name="abbreviation"
                    placeholder="e.g., KJV"
                    maxlength="10"
                    required
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Select JSON File <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="file" 
                        name="bible_file" 
                        id="bibleFile"
                        accept=".json,application/json"
                        required
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer border border-slate-300 rounded-lg cursor-pointer"
                    />
                </div>
                <p class="mt-2 text-xs text-slate-500">Only JSON files are accepted</p>
            </div>

            <div id="fileInfo" class="hidden p-4 bg-slate-50 rounded-lg border border-slate-200">
                <p class="text-sm font-medium text-slate-700 mb-1">Selected File:</p>
                <p id="fileName" class="text-sm text-slate-600"></p>
                <p id="fileSize" class="text-xs text-slate-500 mt-1"></p>
            </div>
            
            <div class="flex gap-3">
                <a 
                    href="<?= base_url('admin/bibles') ?>"
                    class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium text-center"
                >
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all font-medium shadow-lg shadow-blue-500/50"
                >
                    Upload Bible
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('bibleFile').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        
        if (file) {
            // Check if file is JSON
            if (!file.name.endsWith('.json')) {
                alert('Please select a JSON file');
                e.target.value = '';
                fileInfo.classList.add('hidden');
                return;
            }
            
            // Display file info
            fileName.textContent = file.name;
            fileSize.textContent = `Size: ${(file.size / 1024).toFixed(2)} KB`;
            fileInfo.classList.remove('hidden');
        } else {
            fileInfo.classList.add('hidden');
        }
    });

    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        const button = this.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    });
</script>
<?= $this->endSection() ?>

