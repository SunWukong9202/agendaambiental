@props([
    'key' => 'expanded',
    'outsideTrigger' => false,
    'persistent' => true
])

<div
x-ref="expandable"
x-modelable="expanded"
{{ $attributes->whereDoesntStartWith('class') }}
@if ($persistent)
  x-data="{ expanded: $persist(false).as('{{ $key }}').using(sessionStorage) }"
@else
  @expand.window="handle($event.detail)"
  x-data="{ 
    expanded: false,

  }"
@endif 
  > 
    @if (!$outsideTrigger)
      <span
        
        class="cursor-pointer relative"
        @click="expanded = !expanded">
        {{ $trigger }}
      </span>
    @endif

    <ul
        x-show="expanded" x-collapse.duration.300ms
        {{ $attributes->class(['py-2 space-y-2']) }}
        >
        {{ $slot }}
    </ul>

</div>