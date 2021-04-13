@props(['route' => '#', 'btntext' => 'Confirm'])

<div {{ $attributes->merge(['class' => '']) }} x-data="confirmModal()">
    <x-button type="button" class="cursor-pointer"
        @click.prevent="confirmDelete(' {{ $route }}')"
        aria-label="{{ $btntext }}"
    >
        {{ $btntext }}
    </x-button>
</div>

<script>
function confirmModal() {
    return {
        confirmDelete(route) {
            answer = confirm('{{ $slot }}');
            if (answer) {
                window.location.href = route;
            }
        },
    };
}
</script>
