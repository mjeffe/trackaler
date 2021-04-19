<x-app-layout>
    @if (count($trackers))
        <div class="inline-flex items-center">
            <div class="text-2xl text-gray-500">Your Trackers</div>
            <x-help>
                This is your home screen with a list of all trackers. From here you can
                add new trackers or work with your existing trackers.
            </x-help>
        </div>

        <div class="mb-2">
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
