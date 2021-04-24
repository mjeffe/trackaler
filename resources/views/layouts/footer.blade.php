<div class="py-3">
    <div class="max-w-full mx-auto sm:px-2 lg:px-3">
        <div class="bg-white overflow-hidden rounded-lg">
            <div class="p-3 bg-white">
                <nav class="inline-flex space-x-6">
                    <x-nav-link :href="route('credits')" :active="request()->routeIs('credits')">
                        {{ __('Credits') }}
                    </x-nav-link>
                    <x-nav-link :href="route('disclaimer')" :active="request()->routeIs('disclaimer')">
                        {{ __('Privacy Policy') }}
                    </x-nav-link>
                </nav>
                <div class="float-right px-1 pt-1 text-sm font-medium text-gray-500">
                    &#169; 2021 All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
</div>
