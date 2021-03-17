<x-app-layout>
    <x-card>
        <x-slot name="title">
            Track something
        </x-slot>

        <form method="POST" action="{{url('/metrics')}}">
            @csrf

            <label class="block mt-3">
                <x-label for="metric">Select something to track</x-label>
                <x-select id="metric" name="metric">
                    <option value="weight">Weight</option>
                    <option value="calories">Calories</option>
                    <option value="carbs">Carbs</option>
                    <option value="fat">Fat</option>
                    <option value="protein">Protein</option>
                </x-select>
            </label>

            <label class="block mt-3">
                <x-label for="value" class="text-gray-700">Value:</x-label>
                <x-input type="text" id="value" name="value" required placeholder="" class="block" />
            </label>

            <label class="block mt-3">
                <x-label for="measured_on" class="text-gray-700">Measured on Date/Time:</x-label>
                <x-input type="date" id="measured_on" name="measured_on"
                    value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                    required
                    class="block" />
            </label>

            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>
</x-app-layout>
