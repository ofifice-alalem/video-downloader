<x-layout title="الإعدادات - Video Downloader">
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white">
            <h1 class="text-3xl font-bold mb-2">⚙️ الإعدادات</h1>
            <p class="text-blue-100">تخصيص إعدادات التحميل وإدارة الملفات</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Download Settings -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">إعدادات التحميل</h2>
                </div>
                
                <div class="space-y-6">
                    <!-- Download Path -->
                    <div class="p-4 border border-gray-200 rounded-xl">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">📁 مجلد التحميل</label>
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="flex-1 p-3 bg-gray-50 rounded-lg border font-mono text-sm">
                                {{ storage_path('app/downloads') }}
                            </div>
                            <button onclick="openDownloadFolder()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Quality Settings -->
                    <div class="p-4 border border-gray-200 rounded-xl">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">🎥 الجودة الافتراضية</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                                <input type="radio" name="quality" value="1080p" class="text-blue-600">
                                <div class="mr-3">
                                    <div class="font-medium">1080p</div>
                                    <div class="text-xs text-gray-500">عالية الجودة</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border-2 border-blue-300 bg-blue-50 rounded-lg cursor-pointer">
                                <input type="radio" name="quality" value="720p" checked class="text-blue-600">
                                <div class="mr-3">
                                    <div class="font-medium">720p</div>
                                    <div class="text-xs text-gray-500">جودة متوسطة</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                                <input type="radio" name="quality" value="480p" class="text-blue-600">
                                <div class="mr-3">
                                    <div class="font-medium">480p</div>
                                    <div class="text-xs text-gray-500">جودة منخفضة</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Advanced Options -->
                    <div class="p-4 border border-gray-200 rounded-xl">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">⚡ خيارات متقدمة</h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg cursor-pointer">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="mr-3 text-sm">تحميل الصور المصغرة تلقائياً</span>
                            </label>
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg cursor-pointer">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="mr-3 text-sm">تنزيل تلقائي بعد التحليل</span>
                            </label>
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg cursor-pointer">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="mr-3 text-sm">حفظ سجل التحميلات</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Storage Info & Actions -->
            <div class="space-y-6">
                <!-- Storage Stats -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">إحصائيات التخزين</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl">
                            <div class="text-xs text-blue-600 font-medium">المساحة المستخدمة</div>
                            <div class="text-2xl font-bold text-blue-700">2.4 GB</div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl">
                            <div class="text-xs text-green-600 font-medium">عدد الملفات</div>
                            <div class="text-2xl font-bold text-green-700">47</div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl">
                            <div class="text-xs text-purple-600 font-medium">آخر تحميل</div>
                            <div class="text-2xl font-bold text-purple-700">اليوم</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-4">🔧 الإجراءات</h3>
                    <div class="space-y-3">
                        <button class="w-full px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium">
                            💾 حفظ الإعدادات
                        </button>
                        
                        <button onclick="openDownloadFolder()" class="w-full px-4 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors font-medium">
                            📂 فتح مجلد التحميل
                        </button>
                        
                        <button class="w-full px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors font-medium">
                            🗑️ مسح جميع الملفات
                        </button>
                    </div>
                </div>
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
                    showNotification('تم فتح مجلد التحميل', 'success');
                } else {
                    showNotification('فشل في فتح المجلد', 'error');
                }
            });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 left-4 px-6 py-3 rounded-lg text-white font-medium z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
    </script>
</x-layout>