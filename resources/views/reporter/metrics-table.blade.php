<div class="text-2xl text-gray-500">
    {{ Str::title($tracker->metric) }} Tracker Metrics
</div>
<x-card width="md">
    <table class="table-fixed xw-full text-left">
        <thead>
            <tr>
                <th xclass="w-2/6">Value</th>
                <th xclass="w-2/6">Measured On</th>
                <th class="w-1/6">Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tracker->metrics as $m)
                <tr>
                    <td class="border border-secondary-300">{{ $m->value }}</td>
                    <td class="border border-secondary-300" x-data={}>
                        <span x-html="localDateStr({{ $m->measured_on->valueOf() }})"></span>
                    </td>
                    <td class="border border-secondary-300">
                        <a href="{{ route('metric.edit', [$tracker->id, $m->id]) }}">
                            <x-button class="box-border h-5" aria-label="Edit">Edit</x-button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-card>
