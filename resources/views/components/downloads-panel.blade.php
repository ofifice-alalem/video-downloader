<aside class="w-full lg:w-80 bg-white border-r border-gray-200 p-4 lg:p-6 hidden lg:block">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-900">التنزيلات الأخيرة</h2>
        <div class="flex space-x-2 space-x-reverse">
            <button class="p-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                </svg>
            </button>
            <button class="p-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Downloads List -->
    <div class="space-y-4">
        <x-download-item 
            title="فيديو تعليمي - Laravel"
            status="مكتمل"
            progress="100"
            size="45.2 MB"
            icon="✓"
            iconColor="text-green-500"
        />
        
        <x-download-item 
            title="مقطع موسيقي - أغنية جديدة"
            status="جاري التنزيل"
            progress="65"
            size="12.8 MB"
            icon="↓"
            iconColor="text-blue-500"
        />
        
        <x-download-item 
            title="محاضرة - البرمجة الكائنية"
            status="في الانتظار"
            progress="0"
            size="128.5 MB"
            icon="⏸"
            iconColor="text-yellow-500"
        />
        
        <x-download-item 
            title="فيلم قصير - تجريبي"
            status="مكتمل"
            progress="100"
            size="256.7 MB"
            icon="✓"
            iconColor="text-green-500"
        />
    </div>

    <!-- Total Balance Section -->
    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
        <div class="text-sm text-gray-600 mb-1">إجمالي المساحة المستخدمة</div>
        <div class="text-2xl font-bold text-gray-900">2.4 GB</div>
        <div class="text-sm text-green-600">+156 MB اليوم</div>
    </div>
</aside>