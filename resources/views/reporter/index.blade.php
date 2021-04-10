<x-app-layout>
    <x-help class="mb-2">
        <x-slot name="label">
             <span class="text-2xl text-gray-500">{{ Str::title($tracker->metric) }} Tracker</span>
        </x-slot>
        <p class="pb-2">
            This is a graph of all data points you have recoreded for this tracker, and your goal
            if you set one.
        </p>
        <p class="pb-2">
            You can toggle each line on or off by clicking on the name in the legend
            at the bottom of the graph.
        </p>
        <p class="pb-2">
            You can zoom in on a section, by clicking and dragging, or use a two
            finger pinch gesture on mobile devices. Just click the
            <span class="font-semibold">Reset Zoom</span> button to return to the full view.
        </p>
    </x-help>

    @if (count($tracker->metrics))
        <x-card width="full">
            <div class="mt-3">
                @includeWhen(count($tracker->metrics), 'reporter.chart-line')
            </div>
        </x-card>
    @else
        You have not tracked any data for the {{ Str::title($tracker->metric) }} tracker
    @endif
</x-app-layout>
