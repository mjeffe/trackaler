<x-app-layout>
    <x-card width="full">
        <x-page-title>
            {{ config('app.name') }} is a simple tool that lets you set goals,
            track steps toward that goal, and graph your progress.
        </x-page-title>

        <p class="text-gray-500">
            It's free, open source, and (currently) self-funded, so no pesky adds or email.
        </p>

        <!-- div class="flex items-center justify-around md:justify-start w-full mt-3" -->
        <div class="w-full mt-3">

            <div class="flex flex-col lg:flex-row items-center justify-evenly mt-3">
                <div class="max-w-lg mx-auto">
                    <div class="text-4xl font-extrabold text-gray-700 mb-6">
                        Create a tracker
                    </div>
                </div>
                <div class="md:m-3">
                    <img src="{{ asset('img/screenshots/create-tracker.png') }}">
                </div>
            </div>
            <div class="flex flex-col lg:flex-row items-center justify-evenly mt-3">
                <div class="max-w-lg mx-auto">
                    <div class="text-4xl font-extrabold text-gray-700 mb-6">
                        Interact with your trackers
                    </div>
                </div>
                <div class="md:m-3">
                    <img src="{{ asset('img/screenshots/home-screen.png') }}">
                </div>
            </div>
            <div class="flex flex-col lg:flex-row items-center justify-evenly mt-3">
                <div class="max-w-lg mx-auto">
                    <div class="text-4xl font-extrabold text-gray-700 mb-6">
                        Track by adding data points to your trackers
                    </div>
                </div>
                <div class="md:m-3">
                    <img src="{{ asset('img/screenshots/add-metric.png') }}">
                </div>
            </div>
            <div class="flex flex-col lg:flex-row items-center justify-evenly mt-3">
                <div class="max-w-lg mx-auto">
                    <div class="text-4xl font-extrabold text-gray-700 mb-6">
                        Graph your trackers
                    </div>
                </div>
                <div class="md:m-3">
                    <img src="{{ asset('img/screenshots/graph-tracker.png') }}">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-around md:justify-start w-full mt-3">
            <div class="md:m-3">
                <x-a href="{{ route('login') }}">
                    {{ __('Login') }}
                </x-a>
            </div>
            <div class="md:m-3">
                <x-a href="{{ route('register') }}">
                    {{ __('Register') }}
                </x-a>
            </div>
        </div>
    </x-card>

</x-app-layout>
