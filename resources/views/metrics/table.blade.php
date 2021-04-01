<table class="table-auto">
    <thead>
        <tr>
            <td class="px-4 py-2 text-bold text-lg text-gray-700">Metric</td>
            <td class="px-4 py-2 text-bold text-lg">Value</td>
            <td class="px-4 py-2 text-bold text-lg">Measured On</td>
        </tr>
    </thead>
    <tbody>
    @foreach ($data as $row)
        <tr>
            <td class="border border-primary-500 px-4 py-2 font-medium">
                {{ $row->metric }}
            </td>
            <td class="border border-primary-500 px-4 py-2 font-medium">
                {{ $row->value }}
            </td>
            <td class="border border-primary-500 px-4 py-2 font-medium">
                {{ $row->measured_on }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
