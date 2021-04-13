<x-app-layout>
    <x-help>
        <x-slot name="label">
            {{ ($tracker->exists) ? 'Edit this' : 'Create a new' }} tracker
        </x-slot>

        A tracker is simply something you want to track. For example weight loss.
        Don't worry, you can always change this information later by clicking the tracker's
        <img class="inline" height="16" width="16" src="{{ asset('img/iconmonstr-pencil-9.svg') }}">
        (edit) icon.
        <dl>
            <dt class="font-bold">Metric</dt>
            <dd class="ml-4">
                This is the name for your tracker (the thing you are measuring or tracking), so
                use something short such as <span class="font-semibold">weight</span> or
                <span class="font-semibold">daily run</span>.
            </dd>
            <dt class="font-bold">Units</dt>
            <dd class="ml-4">
                The units in which the metric is measured. For a <i>weight</i> metric it could
                be <span class="font-semibold">lb</span>
                or <span class="font-semibold">kg</span>, for a <i>daily run</i> metric it could
                be <span class="font-semibold">mi</span>
                or <span class="font-semibold">km</span>, etc.
            </dd>
            <dt class="font-bold">Description</dt>
            <dd class="ml-4">
                An optional description of this tracker
            </dd>
        </dl>
        <hr>
        <strong>Goals</strong> are optional. If you choose to set a goal, then simply provide
        a <strong>Target</strong> value and optionally a target <strong>Date</strong>. These
        will be added to graphs if you want to visualize progress towards a goal.
    </x-help>

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
                <x-label for="units" class="block">Units: *</x-label>
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
            <x-label for="description" class="block">Description:</x-label>
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

            @if ($tracker->exists)
            <a href="{{ route('tracker.delete', $tracker->id) }}">
                <x-button type="button" class="ml-3" aria-label="Delete this Tracker">Delete</x-button>
            </a>
            @endif
        </form>

    </x-card>
</x-app-layout>
