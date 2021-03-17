<x-app-layout>
    <x-card width="full">
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
            @includeWhen(!empty($data), 'metric-chart-line')
        </div>
    </x-card>
</x-app-layout>
