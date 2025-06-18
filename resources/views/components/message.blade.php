@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
@endif
