<div {{ $attributes->merge(['class' => '']) }}
    x-data="{ showHelp: false }"
    x-cloak
>
    <div class="pl-3 cursor-pointer" @click="showHelp = !showHelp" @click.away="showHelp = false">
        <x-img.help-question-mark class="w-5 h-5"/>
    </div>
    <div class="text-sm p-2 bg-gray-300 rounded absolute z-10 -left-0.5 ml-3 mr-3 transition-opacity"
        x-show="showHelp"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:leave="ease-in duration-300"
        x-transition:leave-end="opacity-0"
>
        <div>{{ $slot }}</div>
    </div>
</div>
