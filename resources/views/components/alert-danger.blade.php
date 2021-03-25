<div x-data="{ show: true }" x-show="show"
     class="flex justify-between items-center
            bg-red-200 relative text-red-700 font-semibold py-3 px-3 rounded-lg">
    {{ $slot }}
    <div>
        <button type="button" @click="show = false" class="text-red-700">
            <span class="text-2xl">&times;</span>
        </button>
    </div>
</div>
