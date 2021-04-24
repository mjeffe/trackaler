<x-app-layout>
    <x-card width="full">
        <x-page-title>
            Tracle is a simple tool that lets you set goals, track stuff toward that goal, and graph your progress.
        </x-page-title>

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
