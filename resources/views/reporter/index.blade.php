<x-app-layout>
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
