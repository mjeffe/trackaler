@props(['btntext' => 'Delete',])

<div {{ $attributes->merge(['class' => '']) }} x-data="confirmXData()">
    <x-button type="button" class="cursor-pointer"
        @click.prevent="confirmDelete()"
        aria-label="{{ $btntext }}"
    >
        {{ $btntext }}
    </x-button>
</div>

<script>
function confirmXData() {
    return {
        confirmDelete() {
            answer = confirm('{{ $message }}');
            if (answer) {
                window.location.href = '{{ $route }}';
            }
        },
    };
}
</script>
