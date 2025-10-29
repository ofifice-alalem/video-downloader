<aside class="w-64 bg-gray-900 text-white flex flex-col fixed lg:relative h-full z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto scrollbar-thin">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-700">
        <div class="flex items-center space-x-3 space-x-reverse">
            <div class="w-8 h-8 bg-neon-green rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12l-4-4h8l-4 4z"/>
                </svg>
            </div>
            <span class="text-xl font-bold">Video Downloader</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto scrollbar-thin">
        <ul class="space-y-2">
            <x-sidebar-item icon="home" label="الرئيسية" href="/" :active="request()->is('/')" />
            <x-sidebar-item icon="download" label="تنزيل جديد" href="/" :active="false" />
            <x-sidebar-item icon="history" label="السجل" href="#" :active="false" />
            <x-sidebar-item icon="settings" label="الإعدادات" href="/settings" :active="request()->is('settings')" />
        </ul>
    </nav>

    <!-- Update Card -->
    <div class="m-4 p-4 bg-gradient-to-br from-neon-green to-green-400 rounded-lg text-gray-900">
        <div class="flex items-center justify-center w-12 h-12 bg-white bg-opacity-20 rounded-lg mb-3">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2L3 9h4v7h6V9h4l-7-7z"/>
            </svg>
        </div>
        <h3 class="font-bold mb-1">تحديث جديد</h3>
        <p class="text-sm opacity-80 mb-3">الإصدار 2.1.0</p>
        <button class="w-full bg-gray-900 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
            تحديث الآن
        </button>
    </div>
</aside>