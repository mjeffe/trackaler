@foreach ($trackers as $t)
    <x-card width="md" class="mb-3">
        <div>
            <span class="font-bold">{{ Str::title($t->metric) }}</span> ({{ $t->units }})

            <a id="edit-tracker" href="{{ route('tracker.edit', $t->id) }}" class="float-right">
                <x-img.edit-pencil class="w-5 h-5 text-gray-600" />
            </a>
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
            <x-button class="h-5" aria-label="{{ config('app.name') }}">Track</x-button>
        </a>

        <a href="{{ route('reporter.graph', $t->id) }}">
            <x-button class="h-5" aria-label="Graph">Graph</x-button>
        </a>

        <a href="{{ route('reporter.metrics', $t->id) }}">
            <x-button class="h-5" aria-label="Metrics">Data</x-button>
        </a>
    </x-card>
@endforeach
