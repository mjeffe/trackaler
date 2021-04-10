<x-app-layout>
@if (session()->get('error'))
    <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
@endif

@if (count($trackers))
    <x-help xclass="float-right">
        <x-slot name="label">
             <span class="text-2xl text-gray-500">Your Trackers</span>
        </x-slot>
        This is the help message
    </x-help>

    <div>
        <a href="{{ route('tracker.create') }}" aria-label="Add a Tracker">
            <x-button class="mt-3" aria-label="Add a tracker">Add a Tracker</x-button>
        </a>
    </div>

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
