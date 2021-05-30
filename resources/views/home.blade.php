<x-app-layout>
    <x-card width="full">
        <x-page-title>
            <span class="text-4xl font-extrabold text-primary-900">{{ config('app.name') }}</span>
            is a simple tool that lets you
            <span class="text-3xl text-gray-900">track</span> stuff
            and <span class="text-3xl text-gray-900">graph</span> it's progress
        </x-page-title>

        <p class="text-gray-500 text-sm">
            It's free, open source, and self-funded, so no pesky adds or email
        </p>

        <div class="lg:grid lg:grid-cols-6">
            <div></div>
            <div class="mt-3 lg:mt-8 text-2xl text-gray-700">
                It's simple:
            </div>
        </div>

        <!-- div class="flex items-center justify-around md:justify-start w-full mt-3" -->
        <div class="w-full sm:mt-3 lg:mt-8">

            <div class="flex flex-col xlg:flex-row items-center justify-evenly mt-3">
                <div class="max-w-lg mx-auto">
                    <div class="text-4xl font-extrabold text-gray-700 mb-6">
                        Create trackers
                    </div>
                </div>
                <div class="md:m-3">
                    <img src="{{ asset('img/screenshots/create-tracker.png') }}" width="500">
                </div>

                <div class="max-w-lg mx-auto mt-3 lg:mt-8">
                    <div class="text-4xl font-extrabold text-gray-700 mb-6">
                        Interact with your trackers
                    </div>
                </div>
                <div class="md:m-3">
                    <img src="{{ asset('img/screenshots/home-screen.png') }}" width="500">
                </div>

                <div class="max-w-lg mx-auto mt-3 lg:mt-8">
                    <div class="text-4xl font-extrabold text-gray-700 mb-6">
                        Track progress 
                    </div>
                </div>
                <div class="md:m-3">
                    <img src="{{ asset('img/screenshots/add-metric.png') }}" width="500">
                </div>

                <div class="max-w-lg mx-auto mt-3 lg:mt-8">
                    <div class="text-4xl font-extrabold text-gray-700 mb-6">
                        Graph your trackers
                    </div>
                </div>
                <div class="md:m-3">
                    <img src="{{ asset('img/screenshots/graph-tracker.png') }}" width="500">
                </div>

                <div class="max-w-lg mx-auto mt-3 lg:mt-8">
                    <div class="md:m-3">
                        <x-a href="{{ route('examples') }}">
                            {{ __('More tracker examples') }}
                        </x-a>
                    </div>
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
