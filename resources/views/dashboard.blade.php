<x-app-layout>
    <div class="text-2xl text-gray-500">
        Welcome!
    </div>

    <x-card width="full">
        The functionality of this site is simple.

        <ul class="list-disc pl-6">
            <li>
                First <x-a href="{{ route('tracker') }}">configure</x-a> what you want to track
            </li>
            <li>
                Then <x-a href="{{ route('tracker') }}">enter data</x-a>
            </li>
            <li>
                Finally <x-a href="{{ route('reporter.index') }}">view</x-a> your progress
            </li>
        </ul>
    </x-card>
</x-app-layout>
