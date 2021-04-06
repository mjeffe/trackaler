@foreach ($trackers as $t)
    <x-card width="md" class="mb-3">
        <div>
            <span class="font-bold">{{ Str::title($t->metric) }}</span> ({{ $t->units }})
            @if (!empty($t->goal_value))
                <div x-data={}>
                    <span class="font-bold">Goal: </span> {{ $t->goal_value }}
                    @if ($t->goal_date)
                        <span class="font-bold pl-4">By: </span>
                        <span x-html="localDateStr({{ $t->goal_date->valueOf() }})"></span>
                    @endif
                </div>
            @endif
        </div>
        <div>
            {{ $t->description }}
        </div>
        <a href="{{ route('metric.create', $t->id) }}">
            <x-button class="h-5" aria-label="Track">Track</x-button>
        </a>

        <a href="{{ route('reporter.graph', $t->id) }}">
            <x-button class="h-5" aria-label="Graph">Graph</x-button>
        </a>

        <a href="{{ route('reporter.metrics', $t->id) }}">
            <x-button class="h-5" aria-label="Metrics">Data</x-button>
        </a>

        <a href="{{ route('tracker.edit', $t->id) }}">
            <x-button class="h-5" aria-label="Edit this Tracker">Edit</x-button>
        </a>

        <a href="{{ route('tracker.delete', $t->id) }}">
            <x-button class="h-5" aria-label="Delete this Tracker">Delete</x-button>
        </a>

    </x-card>
@endforeach
