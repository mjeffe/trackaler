<x-app-layout>
    <x-card>
        <x-slot name="title">
            Track something
        </x-slot>

        <form method="POST" action="{{url('/metrics')}}">
            @csrf

            <div class="mt-3">
                <x-label for="metric" class="block">Select something to track</x-label>
                <x-select id="metric" name="metric">
                    <option value="weight">Weight</option>
                    <option value="calories">Calories</option>
                    <option value="carbs">Carbs</option>
                    <option value="fat">Fat</option>
                    <option value="protein">Protein</option>
                </x-select>
                <x-label for="units" class="sm:ml-5">Units:</x-label>
                <x-units required />
            </div>

            <div class="mt-3">
                <x-label for="value" class="block">Value:</x-label>
                <x-input type="text" id="value" name="value" required />
            </div>

            <div class="mt-3">
                <x-label for="measured_on">Measured on Date/Time:</x-label>
                <x-input type="date" id="measured_on" name="measured_on"
                    value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                    required
                    class="block" />
            </div>

            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>
</x-app-layout>
