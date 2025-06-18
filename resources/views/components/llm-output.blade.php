
@props(['idPrefix' => 'llm-'])

<div id="{{ $idPrefix }}output-area" class="mt-4 p-4 border border-blue-200 rounded-lg bg-blue-50 hidden">
    <h4 class="text-lg font-semibold text-blue-800 mb-2">Hasil Gemini:</h4>
    <textarea id="{{ $idPrefix }}result-textarea" readonly rows="7" class="w-full p-2 border border-blue-300 rounded-md bg-blue-100 text-blue-900 resize-none"></textarea>
    <button type="button" onclick="copyLlmOutput('{{ $idPrefix }}')" class="mt-2 flex items-center space-x-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1.5 px-3 rounded-lg shadow-sm transition duration-300">
        <!-- Ikon Clipboard Copy -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-copy"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 10V4"/><path d="M15 7L12 4L9 7"/></svg>
        <span>Salin Hasil</span>
    </button>
</div>

<script>
    // Fungsi salin hasil LLM (reusable, bisa dipanggil dari mana saja)
    function copyLlmOutput(idPrefix) {
        const textarea = document.getElementById(`${idPrefix}result-textarea`);
        textarea.select();
        // Fallback for older browsers / iframe restrictions
        try {
            document.execCommand('copy');
            alert('Teks berhasil disalin ke clipboard!'); // Idealnya gunakan modal kustom
        } catch (err) {
            console.error('Gagal menyalin teks:', err);
            alert('Gagal menyalin teks. Silakan salin secara manual.'); // Idealnya gunakan modal kustom
        }
    }
</script>
