@props(['type' => 'success'])

@php
    // Tentukan warna berdasarkan tipe notifikasi
    $bgColor = [
        'success' => 'bg-green-500',
        'error' => 'bg-red-500',
        'warning' => 'bg-yellow-500',
        'info' => 'bg-blue-500',
    ][$type] ?? 'bg-gray-500';

    $messageId = 'session-message-' . $type;
@endphp

@if (session($type))
    <div id="{{ $messageId }}" class="{{ $bgColor }} fixed bottom-5 right-5 text-white py-3 px-5 rounded-lg shadow-xl z-50 flex items-center justify-between animate-slide-in">
        <span>{{ session($type) }}</span>
        <button class="ml-4 text-white hover:text-gray-200" onclick="document.getElementById('{{ $messageId }}').style.display='none'">&times;</button>
    </div>

    <style>
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slide-out {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .animate-slide-in { animation: slide-in 0.5s ease-out forwards; }
        .animate-slide-out { animation: slide-out 0.5s ease-in forwards; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            (function() {
                const messageDiv = document.getElementById('{{ $messageId }}');

                if (messageDiv) {
                    setTimeout(() => {
                        messageDiv.classList.remove('animate-slide-in');
                        messageDiv.classList.add('animate-slide-out');

                        setTimeout(() => {
                            messageDiv.remove();
                        }, 500);

                    }, 4000); // 4000ms = 4 detik
                }
            })();
        });
    </script>
@endif