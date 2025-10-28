<x-layout title="الإعدادات - Video Downloader">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">الإعدادات</h1>
        
        <x-advanced-settings />
        
        <div class="bg-white rounded-2xl shadow-lg p-8">
            
            <!-- Download Settings -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">إعدادات التنزيل</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">مجلد التنزيل الحالي</label>
                        <div class="p-3 bg-gray-50 rounded-lg border">
                            <code class="text-sm text-gray-800">{{ storage_path('app/downloads') }}</code>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">سيتم حفظ جميع الملفات المحملة في هذا المجلد</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الجودة الافتراضية</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="1080p">1080p (عالية الجودة)</option>
                            <option value="720p" selected>720p (جودة متوسطة)</option>
                            <option value="480p">480p (جودة منخفضة)</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="autoDownload" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="autoDownload" class="mr-2 text-sm text-gray-700">تنزيل تلقائي بعد التحليل</label>
                    </div>
                </div>
            </div>
            
            <!-- Storage Info -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">معلومات التخزين</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-900">المساحة المستخدمة</h3>
                        <p class="text-2xl font-bold text-blue-600">2.4 GB</p>
                    </div>
                    
                    <div class="p-4 bg-green-50 rounded-lg">
                        <h3 class="text-sm font-medium text-green-900">عدد الملفات</h3>
                        <p class="text-2xl font-bold text-green-600">47</p>
                    </div>
                    
                    <div class="p-4 bg-purple-50 rounded-lg">
                        <h3 class="text-sm font-medium text-purple-900">آخر تنزيل</h3>
                        <p class="text-2xl font-bold text-purple-600">اليوم</p>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex space-x-4 space-x-reverse">
                <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    حفظ الإعدادات
                </button>
                
                <button onclick="openDownloadFolder()" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    فتح مجلد التنزيل
                </button>
                
                <button class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    مسح جميع الملفات
                </button>
            </div>
        </div>
    </div>
    
    <script>
        function openDownloadFolder() {
            fetch('/open-downloads-folder', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('تم فتح مجلد التنزيل');
                } else {
                    alert('فشل في فتح المجلد');
                }
            });
        }
    </script>
</x-layout>