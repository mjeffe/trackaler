@if (count($trackers))
    @foreach ($trackers as $t)
        <x-card width="md" class="mb-3">
            <div>
                <span class="font-bold">{{ Str::title($t->metric) }}</span> ({{ $t->display_units }})
                @if (!empty($t->goal_value))
                    <div x-data={}>
                        <span class="font-bold">Goal: </span> {{ $t->goal_value }}
                        @if ($t->goal_timestamp)
                            <span class="font-bold pl-4">By: </span>
                            <span x-html="localDateStr({{ $t->goal_timestamp->valueOf() }})"></span>
                        @endif
                    </div>
                @endif
            </div>
            <div>
                {{ $t->description }}
            </div>
            <a href="{{ route('metric.create', $t->id) }}" aria-label="Track">
                <x-button class="mt-3 h-5" aria-label="Track">Track</x-button>
            </a>

            <a href="{{ route('tracker.delete', $t->id) }}" aria-label="Delete">
                <x-button class="mt-3 h-5" aria-label="Delete this Tracker">Delete</x-button>
            </a>

            <a href="{{ route('tracker.edit', $t->id) }}" aria-label="Edit">
                <x-button class="mt-3 h-5" aria-label="Edit this Tracker">Edit</x-button>
            </a>
        </x-card>
    @endforeach
@else
    You have no trackers
@endif
