@props(['value'])

<span {{ $attributes->merge(['class' => 'text-md font-light text-gray-400']) }}>
    {{ $value ?? $slot }}
</span>
