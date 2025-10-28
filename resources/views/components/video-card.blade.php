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
        <div id="videoInfo" class="hidden mb-6 p-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-200">
            <div class="flex space-x-4 space-x-reverse">
                <img src="https://via.placeholder.com/160x90" alt="Video Thumbnail" class="w-40 h-24 rounded-lg object-cover shadow-md">
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 mb-2 text-lg leading-tight">عنوان الفيديو</h3>
                    <p class="text-sm text-blue-700 mb-1 font-medium">القناة: اسم القناة</p>
                    <p class="text-sm text-gray-600">المدة: 10:25 | المشاهدات: 1.2M</p>
                    <div class="mt-3 flex items-center space-x-2 space-x-reverse">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            جاهز للتنزيل
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="hidden text-center py-8">
            <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-blue-500">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                جاري تحليل الفيديو...
            </div>
        </div>

        <!-- Error State -->
        <div id="errorState" class="hidden p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="mr-3">
                    <h3 class="text-sm font-medium text-red-800">حدث خطأ</h3>
                    <p id="errorMessage" class="text-sm text-red-700 mt-1"></p>
                </div>
            </div>
        </div>

        <!-- Quality Options (Hidden by default) -->
        <div id="qualityOptions" class="hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-green-500 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    اختر الجودة
                </h3>
                <button onclick="showAllFormats()" class="text-sm text-blue-600 hover:text-blue-800">
                    عرض جميع الجودات
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3"></div>
        </div>
    </div>
</div>

<script>
function analyzeVideo() {
    const url = document.getElementById('videoUrl').value;
    if (!url) {
        showError('يرجى إدخال رابط الفيديو');
        return;
    }
    
    // Reset states
    hideAllStates();
    document.getElementById('loadingState').classList.remove('hidden');
    
    fetch('/analyze', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ url: url })
    })
    .then(response => response.json())
    .then(data => {
        hideAllStates();
        
        if (data.error) {
            showError(data.error);
            return;
        }
        
        // Update video info
        document.querySelector('#videoInfo h3').textContent = data.title;
        document.querySelector('#videoInfo p:nth-child(2)').textContent = `القناة: ${data.channel}`;
        document.querySelector('#videoInfo p:nth-child(3)').textContent = `المدة: ${data.duration} | المشاهدات: ${data.views}`;
        document.querySelector('#videoInfo img').src = data.thumbnail;
        
        // Update quality options
        const qualityGrid = document.querySelector('#qualityOptions .grid');
        qualityGrid.innerHTML = '';
        data.qualities.forEach(quality => {
            qualityGrid.innerHTML += `
                <button onclick="downloadVideo('${quality.quality}')" class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 text-right group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-gray-900">${quality.quality}</span>
                        <span class="text-sm text-gray-500">${quality.format}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">${quality.size}</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </button>
            `;
        });
        
        document.getElementById('videoInfo').classList.remove('hidden');
        document.getElementById('qualityOptions').classList.remove('hidden');
    })
    .catch(error => {
        hideAllStates();
        console.error('Error:', error);
        showError('حدث خطأ في الاتصال بالخادم');
    });
}

function hideAllStates() {
    document.getElementById('loadingState').classList.add('hidden');
    document.getElementById('errorState').classList.add('hidden');
    document.getElementById('videoInfo').classList.add('hidden');
    document.getElementById('qualityOptions').classList.add('hidden');
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorState').classList.remove('hidden');
}

function downloadVideo(quality) {
    const url = document.getElementById('videoUrl').value;
    
    fetch('/download', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ url: url, quality: quality })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            if (typeof refreshDownloads === 'function') {
                setTimeout(refreshDownloads, 1000);
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ في بدء التنزيل');
    });
}

function showAllFormats() {
    const url = document.getElementById('videoUrl').value;
    
    fetch('/get-formats', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ url: url })
    })
    .then(response => response.json())
    .then(data => {
        if (data.formats) {
            // Show formats in a modal or new window
            const newWindow = window.open('', '_blank', 'width=800,height=600');
            newWindow.document.write(`
                <html>
                    <head><title>جميع الجودات المتاحة</title></head>
                    <body style="font-family: Arial; padding: 20px; direction: rtl;">
                        <h2>جميع الجودات المتاحة</h2>
                        <pre style="background: #f5f5f5; padding: 15px; border-radius: 5px; overflow: auto;">${data.formats}</pre>
                    </body>
                </html>
            `);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ في جلب الجودات');
    });
}
</script>