<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Generate API Token<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Generate API Token</h2>
                <p class="text-sm text-slate-600">Create a new access token for your Flutter app</p>
            </div>
        </div>

        <div id="formSection">
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">Important:</p>
                        <p>The token will only be shown once. Make sure to copy it immediately after generation.</p>
                    </div>
                </div>
            </div>

            <form id="tokenForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Token Name <span class="text-slate-400">(Optional)</span>
                    </label>
                    <input 
                        type="text" 
                        id="tokenName"
                        placeholder="e.g., Flutter App Production"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                    >
                    <p class="mt-1 text-xs text-slate-500">Give your token a name to help you identify it later</p>
                </div>
                
                <button 
                    type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all font-medium shadow-lg shadow-blue-500/50"
                >
                    Generate Token
                </button>
            </form>
        </div>

        <div id="resultSection" class="space-y-4 hidden">
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-green-800 mb-1">✓ Token Generated Successfully!</p>
                        <p class="text-xs text-green-700">Copy this token now. You won't be able to see it again for security reasons.</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Your API Token:</label>
                <div class="relative">
                    <textarea 
                        id="generatedToken"
                        readonly
                        rows="3"
                        class="w-full px-4 py-3 pr-24 border border-slate-300 rounded-lg bg-slate-50 font-mono text-sm resize-none"
                    ></textarea>
                    <button 
                        type="button"
                        onclick="copyToken()"
                        class="absolute right-3 top-3 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors font-medium"
                    >
                        Copy
                    </button>
                </div>
            </div>

            <div class="flex gap-3">
                <a 
                    href="<?= base_url('admin') ?>"
                    class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium text-center"
                >
                    Go to Dashboard
                </a>
                <button 
                    type="button"
                    onclick="resetForm()"
                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
                >
                    Generate Another
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToken() {
        const tokenInput = document.getElementById('generatedToken');
        tokenInput.select();
        navigator.clipboard.writeText(tokenInput.value);
        
        const button = event.target;
        button.innerHTML = '✓ Copied!';
        button.classList.add('bg-green-600');
        button.classList.remove('bg-blue-600');
        
        setTimeout(() => {
            button.innerHTML = 'Copy';
            button.classList.remove('bg-green-600');
            button.classList.add('bg-blue-600');
        }, 2000);
    }

    function resetForm() {
        document.getElementById('formSection').classList.remove('hidden');
        document.getElementById('resultSection').classList.add('hidden');
        document.getElementById('tokenName').value = '';
        document.getElementById('generatedToken').value = '';
    }

    document.getElementById('tokenForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const tokenName = document.getElementById('tokenName').value || 'API Token';
        const button = e.target.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        
        button.disabled = true;
        button.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        
        try {
            const response = await fetch('<?= base_url("admin/generate-token") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ name: tokenName })
            });
            
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('generatedToken').value = data.token;
                document.getElementById('formSection').classList.add('hidden');
                document.getElementById('resultSection').classList.remove('hidden');
            } else {
                alert('Error: ' + (data.message || 'Failed to generate token'));
                button.disabled = false;
                button.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error generating token. Please try again.');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    });
</script>
<?= $this->endSection() ?>
