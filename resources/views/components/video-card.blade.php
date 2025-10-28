<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM5 8a1 1 0 000 2h8a1 1 0 100-2H5z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">تنزيل الفيديوهات</h1>
            <p class="text-gray-600">أدخل رابط الفيديو لبدء التنزيل</p>
        </div>

        <!-- URL Input -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">رابط الفيديو</label>
            <div class="flex space-x-3 space-x-reverse">
                <input 
                    type="url" 
                    placeholder="https://www.youtube.com/watch?v=..."
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    id="videoUrl"
                >
                <button 
                    onclick="analyzeVideo()"
                    class="px-6 py-3 bg-gradient-to-r from-neon-green to-green-400 text-gray-900 font-medium rounded-lg hover:shadow-lg transition-all duration-200"
                >
                    تحليل الرابط
                </button>
            </div>
        </div>

        <!-- Video Info (Hidden by default) -->
        <div id="videoInfo" class="hidden mb-6 p-4 bg-gray-50 rounded-lg">
            <div class="flex space-x-4 space-x-reverse">
                <img src="https://via.placeholder.com/120x68" alt="Video Thumbnail" class="w-30 h-17 rounded-lg object-cover">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 mb-1">عنوان الفيديو</h3>
                    <p class="text-sm text-gray-600 mb-2">القناة: اسم القناة</p>
                    <p class="text-sm text-gray-500">المدة: 10:25 | المشاهدات: 1.2M</p>
                </div>
            </div>
        </div>

        <!-- Quality Options (Hidden by default) -->
        <div id="qualityOptions" class="hidden">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">اختر الجودة</h3>
            <div class="grid grid-cols-2 gap-3">
                <x-quality-option quality="1080p" size="156 MB" format="MP4" />
                <x-quality-option quality="720p" size="89 MB" format="MP4" />
                <x-quality-option quality="480p" size="45 MB" format="MP4" />
                <x-quality-option quality="Audio Only" size="12 MB" format="MP3" />
            </div>
        </div>
    </div>
</div>

<script>
function analyzeVideo() {
    const url = document.getElementById('videoUrl').value;
    if (!url) {
        alert('يرجى إدخال رابط الفيديو');
        return;
    }
    
    // Show loading state
    const button = event.target;
    button.textContent = 'جاري التحليل...';
    button.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        document.getElementById('videoInfo').classList.remove('hidden');
        document.getElementById('qualityOptions').classList.remove('hidden');
        button.textContent = 'تحليل الرابط';
        button.disabled = false;
    }, 2000);
}

function downloadVideo(quality) {
    alert(`بدء تنزيل الفيديو بجودة ${quality}`);
}
</script>