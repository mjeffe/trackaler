<x-app-layout>

    <x-card class="mt-6">
        <x-slot name="title">
            Stuff you've tracked
        </x-slot>

        <div x-data="{ selectedMetric: 'weight'}">
            <label class="block mt-3">
                <x-label for="metric">Select the metric you want to view</x-label>
                <x-select id="metric" name="metric" x-model="selectedMetric">
                    <option value="weight">Weight</option>
                    <option value="calories">Calories</option>
                    <option value="carbs">Carbs</option>
                    <option value="fat">Fat</option>
                    <option value="protein">Protein</option>
                </x-select>
            </label>

            <a type="button" :href="'{{url('/metrics')}}' + '/' + selectedMetric"
                    class="mt-3" aria-label="Show">
                Show
            </a>
        </form>

        <div class="mt-12">
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
        </div>

    </x-card>

</x-app-layout>
