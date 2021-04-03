@props(['value'])

<span {{ $attributes->merge(['class' => 'text-lg font-medium text-gray-700']) }}>
    {{ $value ?? $slot }}
</span>
