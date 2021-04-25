<x-app-layout>
    <div class="inline-flex items-center">
        <x-page-title>
            {{ ($tracker->exists) ? 'Edit this' : 'Create a new' }} tracker
        </x-page-title>
        <x-help>
            A tracker is simply something you want to track. For example weight loss.
            Don't worry, you can always change this information later by clicking the tracker's
            <x-img.edit-pencil class="w-4 h-4 text-gray-600 inline" /> (edit) icon.
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
    </div>

    <x-card>
        @if ($tracker->exists)
            <form method="POST" action="{{ route('tracker.update', $tracker->id) }}" class="inline">
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

            <div class="float-right">
                <a href="{{ route('home') }}">
                    <x-button type="button" class="mt-3" aria-label="Cancel">Cancel</x-button>
                <a>
                <x-button class="mt-3 bg-secondary-500 hover:bg-secondary-700" aria-label="Save">
                    Save
                </x-button>
            </div>

        </form>

        @if ($tracker->exists)
        <form id="delete-tracker" class="inline"
              method="POST" action="{{ route('tracker.delete', $tracker->id) }}"
        >
            @method('DELETE')
            @csrf

            <x-confirm-modal class="mt-3" @modal-confirmed="document.forms['delete-tracker'].submit()">
                <x-slot name="button">
                    <x-button type="button" class="bg-secondary-500" aria-label="Delete">
                        Delete
                    </x-button>
                </x-slot>
                <x-slot name="title">
                    Delete tracker
                </x-slot>
                <x-slot name="message">
                        Are you sure you want to delete this tracker? This action cannot be undone.
                        <span class="text-red-400 font-bold">Please note!</span>
                        <span class="font-bold">All data you have recorded
                        for this tracker will also be deleted!</span>
                    <br>
                    <br>
                        Please consider exporting your data before you delete
                </x-slot>
            </x-confirm-modal>
        </form>
        @endif

    </x-card>
</x-app-layout>
