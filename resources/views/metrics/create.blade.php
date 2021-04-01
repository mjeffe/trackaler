<x-app-layout>
    <div class="text-2xl text-gray-500">
        Record data for this Tracker
    </div>
    <x-card width="md">
        <x-slot name="title">
            {{ Str::title($tracker->metric) }} Tracker
        </x-slot>

        @if (session()->get('error'))
            <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
        @endif
        <form method="POST" action="{{ route('metric.store', $tracker->id) }}">
            @csrf

            <div class="mt-3">
                <x-label for="value" class="block">Value ({{ $tracker->display_units }}):</x-label>
                @error('goal_value')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="value" name="value"
                    value="{{ $errors->has('value') ? old('value') : '' }}"
                    class="w-36"
                    required />
            </div>

            <div class="mt-3">
                <x-label for="measured_on" class="block">Measured on date/time:</x-label>
                @error('measured_on')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="date" id="measured_on" name="measured_on"
                    value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                    class="w-36"
                    required />
            </div>

            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>
</x-app-layout>
