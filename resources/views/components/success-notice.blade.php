@if (Session::has('success'))
<x-badge {{ $attributes->merge(['class' => 'absolute transition-opacity']) }}
        x-data="{showBadge: true}"
        x-init="setTimeout(function () { showBadge = false; }, 800)"
        x-show="showBadge"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
>
    <x-img.check-mark class="w-4 h-4 mr-2 inline"/>Success!
</x-badge>
@endif


