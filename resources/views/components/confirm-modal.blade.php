<!-- Adapted from: https://tailwindui.com/components/application-ui/overlays/modals -->
<!-- This example requires Tailwind CSS v2.0+ -->
{{--
    On clicking confirm, this will emit a 'modal-confirmed' event

    required named slots:
        $button // this will be used to both activate the modal and the "confirm" button in the modal
        $title
        $message

    optional named slots:
        $icon
--}}
<div x-data="{showConfirmModal: false}"
     @keydown.escape="showConfirmModal = false"
     {{ $attributes->merge(['class' => '']) }}
>

    <div @click="showConfirmModal = true">
        {{ $button }}
    </div>

    <div x-show="showConfirmModal" aria-modal="true"
        class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay, show/hide based on modal state.  -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                x-show="showConfirmModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            > </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel, show/hide based on modal state.  -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl
                       transform transition sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                @click.away="showConfirmModal = false"
                x-show="showConfirmModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition transform ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full
                                bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                    >
                        @if (empty($icon)) <x-img.exclamation-outline /> @else {{ $icon }} @endif
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ $title }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <div @click.prevent="$dispatch('modal-confirmed')">
                    {{ $button }}
                </div>

                <x-button type="button"
                    @click="showConfirmModal = false"
                    class="mr-2" 
                    aria-label="Cancel"
                >
                    Cancel
                </x-button>
            </div>
        </div>
    </div>
</div>
