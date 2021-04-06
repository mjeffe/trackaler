<x-app-layout>
    @if (count($tracker->metrics))
        @include('reporter.metrics-table')
    @else
        You have not recorded any metrics for this tracker
    @endif
</x-app-layout>
