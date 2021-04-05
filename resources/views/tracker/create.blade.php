<x-app-layout>
    <div class="text-2xl text-gray-500">
        Create a new Tracker
    </div>
    <x-card>
        @if (session()->get('error'))
            <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
        @endif

        @if ($tracker->exists)
            <form method="POST" action="{{ route('tracker.update', $tracker->id) }}">
                @method('put')
                @csrf
        @else
            <form method="POST" action="{{ route('tracker.store') }}">
                @csrf
        @endif

        <div class="grid grid-flow-col grid-cols-2 gap-4">
            <div class="mt-3">
                <x-label for="metric" class="block">Metric: *</x-label>
                @error('name')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="metric" name="metric"
                    value="{{ old('metric') ?? $tracker->metric }}"
                    class="w-full"
                    required />
            </div>

            <div class="mt-3">
                <x-label for="units" class="block">Display Units: *</x-label>
                @error('units')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="units" name="units"
                    value="{{ old('units') ?? $tracker->units }}"
                    class="w-full"
                    required />
            </div>
        </div>

        <div class="mt-3">
            <x-label for="description" class="block">Description: *</x-label>
            @error('description')
                <div class="text-red-700 font-semibold">{{ $message }}</div>
            @enderror
            <x-textarea id="description" name="description" class="w-full" required>
                {{ old('description') ?? $tracker->description }}
            </x-textarea>
        </div>

        <x-label class="block mt-4">Goal <x-text-muted>(optional)</x-text-muted></x-label>
        <div class="grid grid-flow-col grid-cols-2 gap-4">
            <div class="mt-3">
                <x-label for="goal_value" class="block">Target:</x-label>
                @error('goal_value')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="goal_value" name="goal_value"
                    value="{{ old('goal_value') ?? $tracker->goal_value }}"
                    class="w-full"
                    />
            </div>

            <div class="mt-3">
                <x-label for="goal_date" class="block">Date:</x-label>
                @error('goal_date')
                    <div class="text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="date" id="goal_date" name="goal_date"
                    value="{{ $tracker->goal_date ? $tracker->goal_date->format('Y-m-d') : null }}"
                    class="w-full"
                    />
            </div>
        </div>

            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>
</x-app-layout>
