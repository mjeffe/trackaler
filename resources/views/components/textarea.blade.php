@props(['disabled' => false, 'rows' => 2, 'cols' => 40])

<textarea {{ $disabled ? 'disabled' : '' }} {{ $rows }} {{ $cols }}
    {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
{{ $slot }}
</textarea>
