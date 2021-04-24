<x-app-layout>
    <x-page-title>
        Welcome!
    </x-page-title>

    <x-card width="full">
        <x-text>
            The functionality of this site is simple.
        </x-text>
        <x-text>
            First, <x-a href="{{ route('tracker') }}">configure</x-a> what you want to track.
            Then <x-a href="{{ route('tracker') }}">enter data</x-a>. At any time you can
            view your progress by clicking the tracker's <x-button class="h-5">graph</x-button> button.
        </x-text>
    </x-card>
</x-app-layout>
