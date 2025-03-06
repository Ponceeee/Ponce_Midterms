@props(['type' => 'info', 'message'])

@php
    $classes = match ($type) {
        'success' => 'bg-green-50 text-green-800 border-green-200',
        'error'   => 'bg-red-50 text-red-800 border-red-200',
        'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'info'    => 'bg-blue-50 text-blue-800 border-blue-200',
        default   => 'bg-gray-50 text-gray-800 border-gray-200'
    };

    $iconClasses = match ($type) {
        'success' => 'text-green-400',
        'error'   => 'text-red-400',
        'warning' => 'text-yellow-400',
        'info'    => 'text-blue-400',
        default   => 'text-gray-400'
    };
@endphp

<div class="rounded-lg border p-4 {{ $classes }} animate-fade-in-down" 
     x-data="{ show: true }" 
     x-show="show" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            @switch($type)
                @case('success')
                    <i class="fas fa-check-circle {{ $iconClasses }} mr-3 text-xl"></i>
                    @break
                @case('error')
                    <i class="fas fa-exclamation-circle {{ $iconClasses }} mr-3 text-xl"></i>
                    @break
                @case('warning')
                    <i class="fas fa-exclamation-triangle {{ $iconClasses }} mr-3 text-xl"></i>
                    @break
                @default
                    <i class="fas fa-info-circle {{ $iconClasses }} mr-3 text-xl"></i>
            @endswitch
            <p class="text-sm font-medium">{{ $message }}</p>
        </div>
        <button @click="show = false" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div> 