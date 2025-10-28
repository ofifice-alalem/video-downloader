@props(['quality', 'size', 'format'])

<button 
    onclick="downloadVideo('{{ $quality }}')"
    class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 text-right group"
>
    <div class="flex items-center justify-between mb-2">
        <span class="font-semibold text-gray-900">{{ $quality }}</span>
        <span class="text-sm text-gray-500">{{ $format }}</span>
    </div>
    <div class="flex items-center justify-between">
        <span class="text-sm text-gray-600">{{ $size }}</span>
        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
        </svg>
    </div>
</button>