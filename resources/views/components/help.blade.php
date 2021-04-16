<div x-data="{ showHelp: false }" {{ $attributes->merge(['class' => '']) }}>
    <div class="inline-flex items-center">
        {{ $label ?? '' }}
        <div class="pl-3 cursor-pointer" @click="showHelp = !showHelp" @click.away="showHelp = false">
            <x-img.help-question-mark class="w-5 h-5"/>
        </div>
    </div>
    <div x-show.transition="showHelp" class="text-sm p-2 bg-gray-300 rounded">
        <div>{{ $slot }}</div>
    </div>
</div>
