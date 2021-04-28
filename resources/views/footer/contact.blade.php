<x-app-layout>
    <x-card width="full" class="mt-2">
        <x-slot name="title">
            Contact the Webmaster
        </x-slot>

        If you wish to have your account deleted or have some other concern, you can contact
        <x-a href="mailto:{{ $webmasterEmail }}">
            the guy with the spear and magic helmet
        </x-a>
    </x-card>
</x-app-layout>
