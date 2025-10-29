<aside class="w-full lg:w-80 bg-white border-r border-gray-200 p-4 lg:p-6 hidden lg:block h-full overflow-y-auto scrollbar-thin">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-900">التنزيلات الحالية</h2>
        <button onclick="refreshDownloads()" class="p-2 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>

    <!-- Downloads List -->
    <div id="activeDownloadsList" class="space-y-4">
        <div class="text-center text-gray-500 py-8">
            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
            </svg>
            <p>لا يوجد تنزيلات حالية</p>
        </div>
    </div>

    <!-- Recent Downloads Section -->
    <div class="mt-8">
        <h3 class="text-md font-semibold text-gray-900 mb-4">التحميلات الأخيرة</h3>
        <div id="recentDownloadsList" class="space-y-3">
            <!-- Recent downloads will be loaded here -->
        </div>
    </div>

    <!-- Stats Section -->
    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
        <div class="text-sm text-gray-600 mb-1">إجمالي المساحة المستخدمة</div>
        <div class="text-2xl font-bold text-gray-900">2.4 GB</div>
        <div class="text-sm text-green-600">+156 MB اليوم</div>
    </div>
</aside>

<script>
let downloadInterval;

function refreshDownloads() {
    fetch('/active-downloads')
        .then(response => response.json())
        .then(downloads => {
            const container = document.getElementById('activeDownloadsList');
            
            if (downloads.length === 0) {
                container.innerHTML = `
                    <div class="text-center text-gray-500 py-8">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                        </svg>
                        <p>لا يوجد تنزيلات حالية</p>
                    </div>
                `;
                if (downloadInterval) {
                    clearInterval(downloadInterval);
                    downloadInterval = null;
                }
            } else {
                container.innerHTML = downloads.map(download => `
                    <div class="p-3 bg-white rounded-lg border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                    <svg class="w-5 h-5 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900 truncate" title="${download.title}">${download.title}</h3>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-blue-600">${download.status}</span>
                                    <span class="text-xs text-gray-500">${Math.round(download.progress)}%</span>
                                </div>
                                ${download.size ? `<div class="text-xs text-gray-400 mt-1">${download.size} ${download.speed ? '• ' + download.speed : ''}</div>` : ''}
                                <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" style="width: ${download.progress}%"></div>
                                </div>
                                <div class="flex items-center justify-end space-x-2 space-x-reverse mt-2">
                                    <button onclick="pauseDownload('${download.id}')" class="p-1 text-yellow-600 hover:text-yellow-800" title="إيقاف مؤقت">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <button onclick="cancelDownload('${download.id}')" class="p-1 text-red-600 hover:text-red-800" title="إلغاء">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
                
                // Start auto-refresh if not already running
                if (!downloadInterval) {
                    downloadInterval = setInterval(refreshDownloads, 2000);
                }
            }
        })
        .catch(error => console.error('Error fetching downloads:', error));
}

function loadRecentDownloads() {
    fetch('/recent-downloads')
        .then(response => response.json())
        .then(downloads => {
            const container = document.getElementById('recentDownloadsList');
            
            if (downloads.length === 0) {
                container.innerHTML = '<p class="text-sm text-gray-500 text-center py-4">لا يوجد تحميلات أخيرة</p>';
            } else {
                container.innerHTML = downloads.map(download => `
                    <div class="flex items-center space-x-3 space-x-reverse p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-shrink-0">
                            ${download.thumbnail ? 
                                `<img src="${download.thumbnail}" alt="صورة مصغرة" class="w-12 h-8 rounded object-cover border border-gray-200" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                <div class="w-12 h-8 rounded bg-green-100 items-center justify-center text-green-600 hidden">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>` :
                                `<div class="w-12 h-8 rounded bg-green-100 flex items-center justify-center text-green-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-medium text-gray-900 truncate" title="${download.title}">${download.title}</h4>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs text-gray-500">${download.size}</span>
                                <span class="text-xs text-gray-400">${download.date}</span>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
        })
        .catch(error => console.error('Error loading recent downloads:', error));
}

function pauseDownload(downloadId) {
    fetch('/pause-download', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ download_id: downloadId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            refreshDownloads();
        } else {
            alert(data.message || 'فشل في إيقاف التنزيل');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ في إيقاف التنزيل');
    });
}

function cancelDownload(downloadId) {
    if (confirm('هل أنت متأكد من إلغاء هذا التنزيل؟')) {
        fetch('/cancel-download', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ download_id: downloadId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                refreshDownloads();
            } else {
                alert(data.message || 'فشل في إلغاء التنزيل');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في إلغاء التنزيل');
        });
    }
}

// Auto-refresh on page load and debug
document.addEventListener('DOMContentLoaded', function() {
    refreshDownloads();
    loadRecentDownloads();
    console.log('Downloads panel initialized');
});
</script>