<x-app-layout>
    <x-card width="full">
        <x-page-title>
            Tracker examples
        </x-page-title>

        <!-- div class="flex items-center justify-around md:justify-start w-full mt-3" -->
        <div class="w-full sm:mt-3 lg:mt-8">
            <div class="flex flex-col lg:flex-row items-center justify-evenly mt-3">
                <div class=""> 
                    <div class="max-w-lg mx-auto">
                        <div class="text-2xl font-extrabold text-gray-700 mb-6">
                            Tracker with goal value and date
                            <p class="text-base font-normal">
                                I want my weight to be 120 pounds by Oct 1 
                            </p>
                        </div>
                    </div>
                    <div class="md:m-3">
                        <img src="{{ asset('img/screenshots/example-create-tracker1.png') }}" width="500">
                    </div>
                </div>

                <div class=""> 
                    <div class="max-w-lg mx-auto mt-3 lg:mt-8">
                        <div class="text-2xl font-extrabold text-gray-700 mb-6">
                            Resulting graph
                        </div>
                    </div>
                    <div class="md:m-3">
                        <img src="{{ asset('img/screenshots/example-graph-tracker1.png') }}" width="500">
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row items-center justify-evenly mt-3">
                <div class=""> 
                    <div class="max-w-lg mx-auto">
                        <div class="text-2xl font-extrabold text-gray-700 mb-6">
                            Tracker with goal value only
                            <p class="text-base font-normal">
                                I want to keep my daily intake under 1200 calories
                            </p>
                        </div>
                    </div>
                    <div class="md:m-3">
                        <img src="{{ asset('img/screenshots/example-create-tracker2.png') }}" width="500">
                    </div>
                </div>

                <div class=""> 
                    <div class="max-w-lg mx-auto mt-3 lg:mt-8">
                        <div class="text-2xl font-extrabold text-gray-700 mb-6">
                            Resulting graph
                        </div>
                    </div>
                    <div class="md:m-3">
                        <img src="{{ asset('img/screenshots/example-graph-tracker2.png') }}" width="500">
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row items-center justify-evenly mt-3">
                <div class=""> 
                    <div class="max-w-lg mx-auto">
                        <div class="text-2xl font-extrabold text-gray-700 mb-6">
                            Tracker with no goal
                            <p class="text-base font-normal">
                                I just want to track how far I run each day
                            </p>
                        </div>
                    </div>
                    <div class="md:m-3">
                        <img src="{{ asset('img/screenshots/example-create-tracker3.png') }}" width="500">
                    </div>
                </div>

                <div class=""> 
                    <div class="max-w-lg mx-auto mt-3 lg:mt-8">
                        <div class="text-2xl font-extrabold text-gray-700 mb-6">
                            Resulting graph
                        </div>
                    </div>
                    <div class="md:m-3">
                        <img src="{{ asset('img/screenshots/example-graph-tracker3.png') }}" width="500">
                    </div>
                </div>
            </div>
        </div>
    </x-card>

</x-app-layout>
