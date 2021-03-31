<x-app-layout>
    <div class="text-2xl text-gray-500">
        Create a new Tracker
    </div>
    <x-card width="full">
        @if (session()->get('error'))
            <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
        @endif
        <form method="POST" action="{{ route('tracker.store') }}">
            @csrf

            <div class="mt-3">
                <x-label for="metric" class="block">Metric: *</x-label>
                @error('name')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="metric" name="metric"
                    value="{{ $errors->has('metric') ? old('metric') : '' }}"
                    class="w-36"
                    required />
            </div>

            <div class="mt-3">
                <x-label for="display_units" class="block">Display Units: *</x-label>
                @error('display_units')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="display_units" name="display_units"
                    value="{{ $errors->has('display_units') ? old('display_units') : '' }}"
                    class="w-36"
                    required />
            </div>

            <div class="mt-3">
                <x-label for="description" class="block">Description: *</x-label>
                @error('description')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="description" name="description"
                    value="{{ $errors->has('description') ? old('description') : '' }}"
                    class="w-36"
                    required />
            </div>

            <div class="mt-3">
                <x-label for="goal_value" class="block">Goal Value (optional):</x-label>
                @error('goal_value')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="goal_value" name="goal_value"
                    value="{{ $errors->has('goal_value') ? old('goal_value') : '' }}"
                    class="w-36"
                    />
            </div>

            <div class="mt-3">
                <x-label for="goal_timestamp" class="block">Goal date/time (optional):</x-label>
                @error('goal_timestamp')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="date" id="goal_timestamp" name="goal_timestamp"
                    value="{{ $errors->has('goal_timestamp') ? old('goal_timestamp') : '' }}"
                    class="w-36"
                    />
            </div>

            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>
</x-app-layout>
