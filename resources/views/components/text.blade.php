@props(['value'])

<p {{ $attributes->merge(['class' => 'text-lg font-medium text-gray-700']) }}>
    {{ $value ?? $slot }}
</p>
