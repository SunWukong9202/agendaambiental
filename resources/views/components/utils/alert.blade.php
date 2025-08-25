@props([
  'type' => 'Success',
  'title' => '',
  'description' => ''
])

<div 
{{ $attributes->class([
    'border-l-4 p-4',
    'bg-orange-100 border-orange-500 text-orange-700' => $type == 'Warning',
    'bg-blue-100 border-blue-500 text-blue-700' => $type == 'Info',
    'bg-danger-100 border-danger-500 text-danger-700' => $type == 'Danger',
    'bg-green-100 border-green-500 text-green-700' => $type == 'Success'
]) }}
class="bg-" 
role="alert">
    <p class="font-bold">{{ $title }}</p>
    <p>{{ $description }}</p>
    
    @isset($slot)
      {{ $slot }}
    @endisset
    
  </div>