<x-app-layout>
    <x-card width="full">
        <x-page-title>
            {{ config('app.name') }} is a simple tool that lets you set goals,
            track steps toward that goal, and graph your progress.
        </x-page-title>

        <p class="mt-3 text-gray-500">
            It's free, open source, and (currently) self-funded, so no pesky adds or email.
        </p>

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
