<div x-data="{ showHelp: false }" {{ $attributes->merge(['class' => '']) }}>
    <div class="inline-flex items-center">
        {{ $label ?? '' }}
        <div class="pl-3 cursor-pointer" @click="showHelp = !showHelp" @click.away="showHelp = false">
            <img src="{{ asset('img/iconmonstr-help-3-gray.svg') }}" alt="help">
        </div>
    </div>
    <div x-show.transition="showHelp" class="text-sm p-2 bg-gray-300 rounded">
        <div>{{ $slot }}</div>
    </div>
</div>
