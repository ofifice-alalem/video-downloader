<div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">الإعدادات المتقدمة</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- File Format Settings -->
        <div>
            <h3 class="font-medium text-gray-900 mb-3">إعدادات الملف</h3>
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600">
                    <span class="mr-2 text-sm">دمج الصوت والفيديو في MP4</span>
                </label>
                
                <label class="flex items-center">
                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600">
                    <span class="mr-2 text-sm">حفظ الصورة المصغرة</span>
                </label>
                
                <label class="flex items-center">
                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600">
                    <span class="mr-2 text-sm">تضمين الصورة المصغرة في الملف</span>
                </label>
                
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                    <span class="mr-2 text-sm">حفظ الترجمة العربية</span>
                </label>
            </div>
        </div>
        
        <!-- Download Settings -->
        <div>
            <h3 class="font-medium text-gray-900 mb-3">إعدادات التنزيل</h3>
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600">
                    <span class="mr-2 text-sm">استئناف التنزيل المتوقف</span>
                </label>
                
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                    <span class="mr-2 text-sm">تحديد سرعة التنزيل</span>
                </label>
                
                <div class="flex items-center space-x-2 space-x-reverse">
                    <label class="text-sm text-gray-700">السرعة القصوى:</label>
                    <select class="px-2 py-1 border border-gray-300 rounded text-sm">
                        <option>بدون حد</option>
                        <option>1 MB/s</option>
                        <option>5 MB/s</option>
                        <option>10 MB/s</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <!-- File Naming -->
    <div class="mt-6">
        <h3 class="font-medium text-gray-900 mb-3">تسمية الملفات</h3>
        <div class="space-y-3">
            <label class="flex items-center">
                <input type="radio" name="naming" value="title" checked class="text-blue-600">
                <span class="mr-2 text-sm">اسم الفيديو فقط</span>
            </label>
            
            <label class="flex items-center">
                <input type="radio" name="naming" value="date_title" class="text-blue-600">
                <span class="mr-2 text-sm">التاريخ + اسم الفيديو</span>
            </label>
            
            <label class="flex items-center">
                <input type="radio" name="naming" value="channel_title" class="text-blue-600">
                <span class="mr-2 text-sm">القناة + اسم الفيديو</span>
            </label>
        </div>
    </div>
</div>