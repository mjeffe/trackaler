@props(['id' => 'units-select'])

<x-select name="units" id="{{ $id }}"
        {{ $attributes->merge(['class' => 'text-lg font-medium text-gray-700']) }}>
    <option value="lbs" {{ old('units') == 'lbs' ? "selected" : "" }}>Pounds</option>
    <option value="kCal" {{ old('units') == 'kCal' ? "selected" : "" }}>kCal</option>
    <option value="g" {{ old('units') == 'g' ? "selected" : "" }}>Grams</option>
    <option value="mg" {{ old('units') == 'mg' ? "selected" : "" }}>Milligrams</option>
</x-select>
