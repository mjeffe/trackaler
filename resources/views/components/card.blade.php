@props(['width' => 'md'])

<div {{ $attributes->merge(['class' => 'min-h-full flex flex-col sm:justify-center items-center pt-6 sm:pt-0']) }}>
    <div class="w-full sm:max-w-{{ $width }} px-6 py-4 bg-secondary-100 shadow-md overflow-hidden sm:rounded-lg">
        @if (!empty($title))
            <div class="text-2xl text-gray-500 mb-6">
                {{ $title }}
            </div>
        @endif

        {{ $slot }}
    </div>
</div>


