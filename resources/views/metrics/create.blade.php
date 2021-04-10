<x-app-layout>
    <div class="text-2xl text-gray-500">
        Record data for this Tracker
    </div>
    <x-card width="md">
        <x-slot name="title">
            <x-help>
                <x-slot name="label">
                    {{ Str::title($tracker->metric) }} Tracker
                </x-slot>

                @if ($metric->exists)
                    You can edit this data point or delete it entirely
                @else
                    Add a data point for this tracker and the date on which it was measured
                @endif
            </x-help>
        </x-slot>

        @if (session()->get('error'))
            <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
        @endif

        @php
            $measuredOnValue = ($metric->exists)
                ? (old('measure_on') ?? $metric->measured_on->toDateString())
                : (old('measured_on') ?? date('Y-m-d'));
        @endphp

        @if ($metric->exists)
            <form method="POST" action="{{ route('metric.update', [$tracker->id, $metric->id]) }}">
                @method('put')
                @csrf
        @else
            <form method="POST" action="{{ route('metric.store', $tracker->id) }}">
                @csrf
        @endif

            <div class="mt-3">
                <x-label for="value" class="block">Value ({{ $tracker->units }}):</x-label>
                @error('value')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="number" step="any" id="value" name="value"
                    value="{{ $metric->value }}"
                    class="w-36"
                    required />
            </div>

            <div class="mt-3">
                <x-label for="measured_on" class="block">Measured on date:</x-label>
                @error('measured_on')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="date" id="measured_on" name="measured_on"
                    value="{{ $measuredOnValue }}"
                    max="{{ date('Y-m-d') }}"
                    class="w-36"
                    required />
            </div>

            <x-button class="mt-3" aria-label="Save">Save </x-button>

        @if ($metric->exists)
            <a href="{{ route('metric.delete', [$tracker->id, $metric->id]) }}" aria-label="Delete">
                <x-button aria-label="Delete this Metric">Delete</x-button>
            </a>
        @endif
        </form>

    </x-card>
</x-app-layout>
