<x-app-layout>
    <div class="text-2xl text-gray-500">
        Your Trackers
    </div>
    <x-button class="mt-3" aria-label="Create">
        <a href="{{ route('tracker.create') }}" aria-label="Add a Tracker">Add a Tracker</a>
    </x-button>

    @include('tracker-list')
</x-app-layout>
