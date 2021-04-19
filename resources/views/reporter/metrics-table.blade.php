<div class="inline-flex items-center">
    <x-page-title>
        {{ Str::title($tracker->metric) }} Tracker Metrics
    </x-page-title>
    <x-help>
        Click/tap a row to edit
    </x-help>
</div>

<x-card width="md">
    <table class="table-fixed w-full text-left">
        <thead>
            <tr>
                <th xclass="w-2/6">Value</th>
                <th xclass="w-2/6">Measured On</th>
            </tr>
        </thead>
        <tbody x-data="{}">
            @foreach ($tracker->metrics as $m)
                <tr class="cursor-pointer hover:bg-secondary-200"
                    @click="window.location.href='{{ route('metric.edit', [$tracker->id, $m->id]) }}'">
                    <td class="border border-secondary-300">{{ $m->value }}</td>
                    <td class="border border-secondary-300" x-data={}>
                        <span x-html="localDateStr({{ $m->measured_on->valueOf() }})"></span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-card>
