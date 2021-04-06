<x-app-layout>
@if (session()->get('error'))
    <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
@endif

@if (count($trackers))
    <div class="text-2xl text-gray-500">
        Your Trackers
    </div>

    <a href="{{ route('tracker.create') }}" aria-label="Add a Tracker">
        <x-button class="mt-3" aria-label="Add a tracker">Add a Tracker</x-button>
    </a>

    @include('tracker.list')
@else
    <x-card width="full">
        <div class="text-2xl text-gray-500">
            Tracal is a simple tool that lets you set goals, track stuff toward
            that goal, and graph your progress.
        </div>

        <a href="{{ route('tracker.create') }}" aria-label="Add a Tracker">
            <x-button class="mt-3" aria-label="Add a tracker">Add a Tracker</x-button>
        </a>
    </x-card>
@endif
</x-app-layout>
