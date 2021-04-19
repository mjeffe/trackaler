<x-app-layout>
    <x-page-title>
        Welcome!
    </x-page-title>

    <x-card width="full">
        <p>
            The functionality of this site is simple.
        </p>
        <p>
            First, <x-a href="{{ route('tracker') }}">configure</x-a> what you want to track.
            Then <x-a href="{{ route('tracker') }}">enter data</x-a>. At any time you can
            <x-a href="{{ route('reporter.index') }}">view</x-a> your progress.
        </p>
    </x-card>
</x-app-layout>
