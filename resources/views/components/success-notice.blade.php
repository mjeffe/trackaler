@if (Session::has('success'))
<div {{ $attributes->merge(['class' => 'absolute z-10 transition-opacity w-full bg-green-400 text-white font-semibold text-md text-center rounded-md']) }}
        x-data="{showBadge: true}"
        x-init="setTimeout(function () { showBadge = false; }, 300)"
        x-cloak
        x-show="showBadge"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:leave="ease-in duration-500"
        x-transition:leave-end="opacity-0"
>
    <x-img.check-mark class="w-4 h-4 mr-2 inline"/>Success!
</div>
@endif


