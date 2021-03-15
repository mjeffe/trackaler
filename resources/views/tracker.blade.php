<x-app-layout>

    <x-card class="mt-6">
        <x-slot name="title">
            Select a metric to track
        </x-slot>

        <form method="POST" action="{{url('/metrics')}}">
            @csrf

            <label class="block mt-3">
                <x-label>Select something to track</x-label>
                <x-select id="metric_type" name="metric_type" xsize="7">
                    <option value="weight">Weight</option>
                    <option value="calories">Calories</option>
                    <option value="carbs">Carbs</option>
                    <option value="fat">Fat</option>
                    <option value="protein">Protein</option>
                </x-select>
            </label>

            <label class="block mt-3">
                <x-label class="text-gray-700">Value:</x-label>
                <x-input type="text" name="metric_value" required placeholder="" class="block" />
            </label>

            <label class="block mt-3">
                <x-label class="text-gray-700">Measured on Date/Time:</x-label>
                <x-input type="datetime-local" name="measured_on" required placeholder="" class="block" />
            </label>

            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>

</x-app-layout>
