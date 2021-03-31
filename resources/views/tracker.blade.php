<x-app-layout>
    <div class="text-2xl text-gray-500">
        Your Trackers
    </div>
    <a href="{{ route('tracker.create') }}" aria-label="Add a Tracker">
        <x-button class="mt-3" aria-label="Add a tracker">Add a Tracker</x-button>
    </a>

    @if (session()->get('error'))
        <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
    @endif
    @include('tracker-list')
</x-app-layout>
