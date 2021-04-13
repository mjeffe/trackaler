<x-app-layout>
    @if (count($tracker->metrics))
        @include('reporter.chart-line')
    @else
        You have not recorded any data for this tracker
    @endif
</x-app-layout>
