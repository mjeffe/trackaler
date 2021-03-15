@props(['disabled' => false, 'options' => '-- please select --', 'width' => '48'])

@php
switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}
@endphp

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    {{ $slot }}
</select>
