@props(['title', 'status', 'progress', 'size', 'icon', 'iconColor'])

<div class="flex items-center space-x-3 space-x-reverse p-3 bg-white rounded-lg border border-gray-100 hover:shadow-md transition-shadow">
    <div class="flex-shrink-0">
        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center {{ $iconColor }}">
            <span class="text-lg font-bold">{{ $icon }}</span>
        </div>
    </div>
    
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between mb-1">
            <h3 class="text-sm font-medium text-gray-900 truncate">{{ $title }}</h3>
            <span class="text-xs text-gray-500">{{ $size }}</span>
        </div>
        
        <div class="flex items-center justify-between">
            <span class="text-xs {{ $status === 'مكتمل' ? 'text-green-600' : ($status === 'جاري التنزيل' ? 'text-blue-600' : 'text-yellow-600') }}">
                {{ $status }}
            </span>
            @if($progress > 0)
                <span class="text-xs text-gray-500">{{ $progress }}%</span>
            @endif
        </div>
        
        @if($progress > 0 && $progress < 100)
            <div class="mt-2 w-full bg-gray-200 rounded-full h-1">
                <div class="bg-blue-500 h-1 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
            </div>
        @endif
    </div>
</div>