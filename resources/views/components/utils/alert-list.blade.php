@props([
    'type' => 'info',
    'title' => 'Title',
    'list' => []
])

<div 
{{ $attributes->class([
    'flex p-4 mb-4 text-sm rounded-lg',
    'text-blue-800 bg-blue-50 dark:bg-gray-800 dark:text-blue-400'
        => $type == 'info',
    'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400'
        => $type == 'danger'
]) }}
class="" role="alert">
    <x-icon.info-circle></x-icon>
    <span class="sr-only">Info</span>
    <div>
      <span class="font-medium">{{ $title }}</span>
        <ul class="mt-1.5 list-disc list-inside">
            @if ($slot->isEmpty())
                @foreach ($list as $item)
                    <li>{{ $item }}</li>
                @endforeach
            @else
                {{ $slot }}
            @endif
      </ul>
    </div>
  </div>
  