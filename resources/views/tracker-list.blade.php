@if (count($trackers))
    @foreach ($trackers as $t)
        <x-card width="md" class="mb-3">
            <div>
                <span class="font-bold">{{ Str::title($t->metric) }}</span> ({{ $t->display_units }})
                @if (!empty($t->goal_value))
                    <div>
                        <span class="font-bold">Goal: </span> {{ $t->goal_value }}
                        @if ($t->goal_timestamp)
                            <span class="font-bold pl-4">By: </span>{{ $t->goal_timestamp }}
                        @endif
                    </div>
                @endif
            </div>
            <div>
                {{ $t->description }}
            </div>
            <x-button type="button" class="mt-3 h-5" aria-label="Track">
                Track
            </x-button>

            <x-button type="button" class="mt-3 h-5" aria-label="Delete">
                Delete
            </x-button>

            <x-button type="button" class="mt-3 h-5" aria-label="Edit">
                Edit
            </x-button>
        </x-card>
    @endforeach
@else
    You have no trackers
@endif
