<x-app-layout>

    <!-- weight-->
    <x-card>
        <x-slot name="title">
            Enter your weight
        </x-slot>

        <form method="POST" action="{{url('/metrics')}}">
            @csrf
            <input type="hidden" name="metric-type" value="weight"/>
            <label class="block mt-3">
                <x-label class="text-gray-700">Weight:</x-label>
                <x-input type="number" name="metric-value" required placeholder="" class="block" />
            </label>
            <label class="block mt-3">
                <x-label class="text-gray-700">Measured on Date/Time:</x-label>
                <x-input type="datetime-local" id="measured-on" required placeholder="" class="block" />
            </label>
            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>

    <!-- calories -->
    <x-card class="mt-6">
        <x-slot name="title">
            Enter calories for the day
        </x-slot>

        <form method="POST" action="{{url('/metrics')}}">
            @csrf
            <input type="hidden" name="metric-type" value="calories"/>
            <label class="block mt-3">
                <x-label class="text-gray-700">Calories:</x-label>
                <x-input type="number" name="metric-value" required placeholder="" class="block" />
            </label>
            <label class="block mt-3">
                <x-label class="text-gray-700">Measured on Date/Time:</x-label>
                <x-input type="datetime-local" name="measured-on" required placeholder="" class="block" />
            </label>
            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>

</x-app-layout>
