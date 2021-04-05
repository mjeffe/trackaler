<x-app-layout>
    <div class="text-2xl text-gray-500">
        Select the metric you want to view
    </div>
    <div x-data="{ selectedMetric: '{{ $trackers->first()->metric }}' }">
        <x-select id="metric" name="metric" x-model="selectedMetric">
        @foreach ($trackers as $t)
            <option value="{{ $t->metric }}">{{ Str::title($t->metric) }}</option>
        @endforeach
        </x-select>

        <a :href="'{{ url("reporter") }}/' + selectedMetric + '/graph'">
            <x-button class="mt-3 ml-3" aria-label="Show">Show</x-button>
        </a>
    </form>

    @if (count($tracker->metrics))
    <x-card width="full">
        <div class="mt-3">
            @includeWhen(count($tracker->metrics), 'reporter.chart-line')
        </div>
    </x-card>
    @endif
</x-app-layout>
