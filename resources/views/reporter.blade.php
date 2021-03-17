<x-app-layout>

    <x-card class="mt-6" width="full">
        <x-slot name="title">
            Stuff you've tracked
        </x-slot>

        <div x-data="{ selectedMetric: 'weight' }">
            <x-label for="metric">Select the metric you want to view</x-label>
            <x-select id="metric" name="metric" x-model="selectedMetric">
                <option value="weight">Weight</option>
                <option value="calories">Calories</option>
                <option value="carbs">Carbs</option>
                <option value="fat">Fat</option>
                <option value="protein">Protein</option>
            </x-select>

            <x-button class="mt-3 ml-3" aria-label="Show">
                <a :href="'{{ url('/metrics') }}' + '/' + selectedMetric">Show</a>
            </x-button>
        </form>

        <div class="mt-3">
            @include('metric-table')
        </div>
    </x-card>

</x-app-layout>
