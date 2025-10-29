<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Video Downloader' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: linear-gradient(135deg, #2563eb, #7c3aed); }
        .scrollbar-thin { scrollbar-width: thin; scrollbar-color: #3b82f6 #f1f5f9; }
        .scrollbar-left { direction: rtl; }
        .scrollbar-left::-webkit-scrollbar { width: 4px; }
        .scrollbar-left::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        .scrollbar-left::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 10px; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Cairo', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    },
                    colors: {
                        'neon-green': '#84ff00',
                        'dark-bg': '#0f0f0f',
                        'card-dark': '#1a1a1a',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Mobile menu button -->
        <button id="mobile-menu-btn" class="lg:hidden fixed top-4 right-4 z-50 p-2 bg-gray-900 text-white rounded-lg">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
            </svg>
        </button>
        
        <x-sidebar />
        <div class="flex-1 flex flex-col lg:flex-row">
            <main class="flex-1 p-4 lg:p-6 overflow-y-auto h-full scrollbar-left">
                {{ $slot }}
            </main>
            <x-downloads-panel />
        </div>
    </div>
    
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>