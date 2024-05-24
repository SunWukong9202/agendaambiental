@props([
  'type' => 'info'
])

<div 
{{ $attributes->class([
  'flex items-center p-4 mb-4 text-sm rounded-lg border',
  'text-blue-800 bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border-blue-200'
    => $type == 'info',
  'text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border-red-200'
    => $type == 'danger',

  'bg-yellow-50 border-yellow-200 text-yellow-800 rounded-lg dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500' => $type == 'warning',
]) }} role="alert">
    @if ($type == 'info')
      <svg class="flex-shrink-0 self-start inline w-4 h-4 mr-4 my-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
      </svg>
      <span class="sr-only">Info</span>
    @elseif($type == 'warning')
      <svg class="flex-shrink-0 self-start inline w-4 h-4 mr-4 my-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
        <path d="M12 9v4"></path>
        <path d="M12 17h.01"></path>
      </svg>
    @endif
    <div>
        {{ $slot }}
    </div>
</div>

  