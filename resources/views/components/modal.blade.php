@props([
    'header',
    'outsideTrigger' => false,
])

<div
  x-data="{ open: false }"
  x-modelable="open"
  {{ $attributes->whereDoesntStartWith('class') }}
  >
  <!-- Trigger -->
  @if (!$outsideTrigger)
  <span x-on:click="open = true">
    {{ $button }}
  </span>
  @endif

  <!-- Modal -->
  <div
    x-show="open"
    role="dialog"
    x-cloak
    aria-modal="true"
    x-id="['modal-title']"
    aria-labelledby="modal-title-3"
    :aria-labelledby="$id('modal-title')"
    x-on:keydown.escape.prevent.stop="open = false"
    class="fixed inset-0 z-50 w-screen overflow-y-auto">
    <!-- Overlay -->
    <div
      x-show="open"
      x-transition.opacity=""
      class="fixed inset-0 bg-gray-500 bg-opacity-50">
    </div>
    <!-- Panel -->
    <div
      x-show="open"
      x-on:click="open = false"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="transform opacity-0 translate-y-full"
      x-transition:enter-end="transform opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="transform opacity-100 translate-y-0"
      x-transition:leave-end="transform opacity-0 translate-y-full"
      class="relative flex min-h-screen items-center justify-center p-4">
      <div
        x-on:click.stop=""
        x-trap.noscroll.inert="open"
        {{ $attributes->class([
          'relative w-full max-w-xl overflow-y-auto shadow-2xl bg-white ring-1 ring-gray-200 rounded-xl'
        ]) }} >
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                @if ($header instanceof \Illuminate\View\ComponentSlot)
                    {{ $header }}
                @else
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $header }}
                </h3>
                @endif
                <button 
                @click="open = false"
                type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                {{ $slot }}
            </div>
      </div>
    </div>
  </div>
</div>