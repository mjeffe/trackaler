<x-app-layout>
    <div class="text-2xl text-gray-500">
        Let's configure stuff
    </div>
    <x-card width="full">
        <form method="POST" action="{{ route('configure.store') }}">
            @csrf

            <!-- trackables -->
            <div>
                <x-label for="metric" class="block">Metric (the thing you want to track)</x-label>
                @error('metric')
                    <div class="block text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="metric" name="metric" required />
            </div>

            <div class="mt-3">
                <x-label for="units" class="block">Units (the units your metric is measured in for display purposes only)</x-label>
                @error('units')
                    <div class="block text-red-700 font-semibold">{{ $message }}</div>
                @enderror
                <x-input type="text" id="units" name="units" required />
            </div>

            <div class="mt-3">
                <x-label class="block">Datatype (the datatype of the units)</x-label>
                <div>
                    <span>
                        <input type="radio" id="datatype_number" name="datatype" value="number" class="text-green-600"
                            checked>
                        <label for="datatype_number">Number</label>
                    </span>
                    <span class="ml-3">
                        <input type="radio" id="datatype_text" name="datatype" value="text" class="text-green-600">
                        <label for="datatype_text">Text</label>
                    </span>
                </div>
            <x-button class="mt-3" aria-label="Save">Save </x-button>
        </form>
    </x-card>
</x-app-layout>
