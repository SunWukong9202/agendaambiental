@props([
    'label',
])

<div 
x-id="['text-area']"
{{ $attributes->class(['w-full']) }}>
    @if ($label instanceof \Illuminate\View\ComponentSlot)
        {{ $label }}
    @else
    <label for="message" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">
        {{ $label }}
    </label>
    @endif
    <textarea 
    {{ $attributes->whereDoesntStartWith('class') }}
    id="['text-area']" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
</div>
  