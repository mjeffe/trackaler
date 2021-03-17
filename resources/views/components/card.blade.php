@props(['width' => 'md'])

@php
$widthClass = 'sm:max-w-' . $width;
@endphp

<div {{ $attributes->merge(['class' => 'min-h-full flex flex-col sm:justify-center items-center pt-6 sm:pt-0']) }}>
    <div class="text-2xl text-gray-700">
        {{ $title }}
    </div>

    <div class="w-full {{ $widthClass }} mt-6 px-6 py-4 bg-secondary-100 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>


