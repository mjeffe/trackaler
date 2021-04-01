@if (count($trackers))
    <div class="text-2xl text-gray-500">
        Your Trackers
    </div>
    <x-card width="full">
        <ul class="list-disc">
            @foreach ($trackers as $tracker)
                <li>{{ Str::title($tracker) }} Tracker</li>
            @endforeach
        </ul>
    </x-card>
<hr class="mt-3">
    <div class="text-2xl text-gray-500">
        Your Trackers
    </div>
    <x-card width="full">
        <table class="table-fixed w-full text-left">
            <thead>
                <tr>
                    <th class="w-1/12">Track</th>
                    <th class="w-1/12">Metric</th>
                    <th class="w-4/12">Description</th>
                    <th xclass="w-1/6">Goal Value</th>
                    <th xclass="w-1/6">Goal Target Date</th>
                    <th xclass="w-1/6">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trackers as $tracker)
                    <tr>
                        <td class="border border-secondary-300">
                            <x-button class="box-border h-5" aria-label="Track">Track</x-button>
                        </li>
                        <td class="border border-secondary-300">{{ Str::title($tracker->name) }}</li>
                        <td class="border border-secondary-300">{{ Str::title($tracker->description) }}</li>
                        <td class="border border-secondary-300">{{ Str::title($tracker->goal_value) }}</li>
                        <td class="border border-secondary-300">{{ Str::title($tracker->goal_datetime) }}</li>
                        <td class="border border-secondary-300">
                            <x-button class="box-border h-5" aria-label="Edit">Edit</x-button>
                            <x-button class="box-border h-5" aria-label="Delete">Delete</x-button>
                        </li>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>
@else
    You have no trackers
@endif
