<x-app-layout>
    <x-card width="full" class="mt-2">
        <x-slot name="title">
            Disclaimer:
        </x-slot>
        <div class="mb-3">
            <span class="font-bold">Please read the first few!</span> They actually are important.
        </div>
        <ol class="list-alpha pl-6">
            <li>
                If you wish to track sensitive data, then consider registering
                with a fake name and email. The only reason email is used as a user ID, is that
                it serves as a nice, unique identifier which most people can remember, and it
                provides a reasonably secure method for password resets.
            </li>
            <li>
                I am a software developer, and this is a hobby project.
            </li>
            <li>
                I have no desire to profit from your data. As such, it's just
                sitting in a database. I don't sell it, mine it, peep in on it, sleep with it, or
                mess around with it in any way. Although, I could if I wanted to, because...
                well... I'm the database administrator.
            </li>
            <li>
                I have used 
                <x-nav-link :href="route('credits')" :active="request()->routeIs('credits')">
                    {{ __('modern tools') }}
                </x-nav-link>
                and made every effort to implement good security, but please
                consider the implications if this site were hacked, and your data stolen.
            </li>
            <li>
                And the standard CYA protections...<br />
                Any and all of software, services, confidential information, and any other
                technology or materials provided on this site to you the customer, are provided
                "as is" and without warranty of any kind. By using this site, you the customer
                acknowledge that there are risks inherent in Internet connectivity that could
                result in the loss of customer's privacy, data, confidential information and
                property.  I cannot guarantee the accuracy of the applications, their
                functionality, or the validity of information found here.  While I make
                reasonable efforts to ensure the application works as described, I give no
                warranty and accept no responsibility or liability for the accuracy or
                completeness of the information, materials, and applications contained in this
                website. USE AT YOUR OWN RISK!
            </li>
        </ol>
    </x-card>
</x-app-layout>
