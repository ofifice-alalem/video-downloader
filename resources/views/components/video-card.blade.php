<div class="w-full px-6">


    <div class="bg-white rounded-3xl shadow-2xl p-8 backdrop-blur-sm border border-gray-100">

        <!-- URL Input -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center ml-3">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">أدخل رابط الفيديو</h2>
            </div>
            <div class="space-y-4">
                <input 
                    type="url" 
                    placeholder="https://www.youtube.com/watch?v=... أو أي رابط فيديو آخر"
                    class="w-full px-6 py-4 text-lg text-center border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200"
                    id="videoUrl"
                >
                <button 
                    onclick="analyzeVideo()"
                    class="w-full px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold text-lg rounded-2xl hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center"
                >
                    <svg class="w-6 h-6 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                    تحليل الرابط
                </button>
            </div>
            <div class="flex items-center justify-center space-x-8 space-x-reverse mt-4 text-sm text-gray-500">
                <div class="flex items-center">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23FF0000'%3E%3Cpath d='M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z'/%3E%3C/svg%3E" class="w-5 h-5 ml-1" alt="YouTube">
                    YouTube
                </div>
                <div class="flex items-center">
                    <div class="w-5 h-5 bg-gradient-to-r from-purple-500 to-pink-500 rounded ml-1"></div>
                    Instagram
                </div>
                <div class="flex items-center">
                    <div class="w-5 h-5 bg-black rounded ml-1"></div>
                    TikTok
                </div>
                <div class="text-gray-400">ومواقع أخرى...</div>
            </div>
        </div>

        <!-- Video Info (Hidden by default) -->
        <div id="videoInfo" class="hidden mb-8 p-6 bg-gradient-to-br from-green-50 via-blue-50 to-purple-50 rounded-2xl border-2 border-green-200 shadow-lg">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center ml-3">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">تم تحليل الفيديو بنجاح</h2>
            </div>
            <div class="flex space-x-6 space-x-reverse">
                <div class="relative">
                    <img src="https://via.placeholder.com/200x120" alt="Video Thumbnail" class="w-48 h-28 rounded-xl object-cover shadow-lg border-2 border-white">
                    <div class="absolute inset-0 bg-black/20 rounded-xl flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 mb-3 text-xl leading-tight">عنوان الفيديو</h3>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-blue-700 font-medium flex items-center">
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                            </svg>
                            اسم القناة
                        </p>
                        <p class="text-sm text-gray-600 flex items-center">
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            10:25
                        </p>
                        <p class="text-sm text-gray-600 flex items-center">
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            1.2M مشاهدة
                        </p>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg">
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            جاهز للتحميل
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
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center ml-3">
                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">اختر جودة التحميل</h3>
                </div>
                <button onclick="showAllFormats()" class="px-4 py-2 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors">
                    🔍 عرض جميع الجودات
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
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
                <button onclick="downloadVideo('${quality.quality}')" class="relative p-6 border-2 border-gray-200 rounded-2xl hover:border-blue-500 hover:shadow-xl transition-all duration-300 text-right group bg-gradient-to-br from-white to-gray-50 hover:from-blue-50 hover:to-purple-50">
                    <div class="mb-3">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl font-bold text-gray-900">${quality.quality}</span>
                            <span class="px-3 py-1 text-xs font-bold bg-gray-100 text-gray-600 rounded-full">${quality.format}</span>
                        </div>
                        <div class="text-sm text-gray-600 font-medium">${quality.size}</div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-500 group-hover:text-blue-600 transition-colors">انقر للتحميل</div>
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
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