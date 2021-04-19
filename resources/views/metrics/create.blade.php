@php
// Throught this site, we use the same form for creating and editing.  Here, we
// need to figure out what we want to put in the measured_on date field.  When
// editing, obviously, it needs to be filled with the existing value. However,
// for a nice "create" workflow, we assume the user is going to enter today's
// data, so prefill with today. We further assume that the user may want to
// enter multiple metrics at once (i.e. enter all of last week's metrics), so
// after save, we return user to this form and increment the day by 1.
//
// figure out what to put in the measured_on date field
if ($metric->exists) {
    // editing, use existing value
    $measuredOnValue = $metric->measured_on->toDateString();
} else {
    // creating, if old() exists, then increment by one day, else it's today
    $measuredOnValue = date('Y-m-d');
    if (old('measured_on')) {
        $dt = new Illuminate\Support\Carbon(strtotime(old('measured_on')));
        $measuredOnValue = $dt->addDay(1)->toDateString();
    }
}
@endphp

<x-app-layout>
    <x-success-notice />

    <div class="inline-flex items-center">
        <div class="text-2xl text-gray-500">
            {{ ($metric->exists) ? 'Edit the' : 'Add a' }} data point
        </div>
        <x-help>
            @if ($metric->exists)
                You can edit this data point or delete it entirely
            @else
                Add a data point for this tracker and the date on which it was recorded
            @endif
        </x-help>
    </div>

    <x-card width="md">
        <x-slot name="title">
            {{ Str::title($tracker->metric) }} Tracker
        </x-slot>

        @if (session()->get('error'))
            <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
        @endif

        @if ($metric->exists)
            <form id="edit-metric" class="inline"
                  method="POST" action="{{ route('metric.update', [$tracker->id, $metric->id]) }}"
            >
                @method('PUT')
        @else
            <form id="create-metric"
                  method="POST" action="{{ route('metric.store', $tracker->id) }}"
            >
        @endif

            @csrf

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
        </form>

        @if ($metric->exists)
        <form id="delete-metric" class="inline"
              method="POST" action="{{ route('metric.delete', [$tracker->id, $metric->id]) }}"
        >
            @method('DELETE')
            @csrf

            <x-confirm-modal class="mt-3 float-right" @modal-confirmed="document.forms['delete-metric'].submit()">
                <x-slot name="button">
                    <x-button type="button" class="bg-secondary-500" aria-label="Delete">
                        Delete
                    </x-button>
                </x-slot>
                <x-slot name="title">
                    Delete data point
                </x-slot>
                <x-slot name="message">
                    Are you sure you want to delete? This action cannot be undone.
                </x-slot>
            </x-confirm-modal>
        </form>
        @endif
    </x-card>
</x-app-layout>
