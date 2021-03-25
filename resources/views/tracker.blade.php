<x-app-layout>
    <x-card>
        <x-slot name="title">
            Track something
        </x-slot>

        @if (session()->get('error'))
            <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
        @endif
        <form method="POST" action="{{ route('tracker.store') }}">
            @csrf

            <div class="mt-3">
                <x-label for="metric" class="block">Select something to track</x-label>
                <x-select id="metric" name="metric">
                    <option value="weight" {{ old('metric') == 'weight' ? "selected" : "" }}>Weight</option>
                    <option value="calories" {{ old('metric') == 'calories' ? "selected" : "" }}>Calories</option>
                    <option value="carbs" {{ old('metric') == 'carbs' ? "selected" : "" }}>Carbs</option>
                    <option value="fat" {{ old('metric') == 'fat' ? "selected" : "" }}>Fat</option>
                    <option value="protein" {{ old('metric') == 'protein' ? "selected" : "" }}>Protein</option>
                </x-select>
                <x-label for="units" class="sm:ml-5">Units:</x-label>
                <x-units required />
            </div>

            <div class="mt-3">
                <x-label for="value" class="block">Value:</x-label>
                @error('value')
                    <div class="block text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="value" name="value" value="{{ $errors->has('value') ? old('value') : '' }}" required />
            </div>

            <div class="mt-3">
                <x-label for="measured_on">Measured on Date/Time:</x-label>
                @error('measured_on')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="date" id="measured_on" name="measured_on"
                    value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                    required
                    class="block" />
            </div>

            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>
</x-app-layout>
