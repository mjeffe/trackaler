@props(['id' => 'units-select'])

<x-select name="units" id="{{ $id }}"
        {{ $attributes->merge(['class' => 'text-lg font-medium text-gray-700']) }}>
    <option value="lbs">Pounds</option>
    <option value="kCal">kCal</option>
    <option value="g">Grams</option>
    <option value="mg">Milligrams</option>
</x-select>
