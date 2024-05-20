@props([
    'key' => 'expanded',
    'persistent' => true
])

<div
x-ref="expandable"
@if ($persistent)
  x-data="{ expanded: $persist(false).as('{{ $key }}').using(sessionStorage) }"
@else
  @expand.window="handle($event.detail)"
  x-data="{ 
    expanded: false,
    handle(self) {
      console.log('in handle');
      console.log(self, this)
      if(self == this) {
        console.log('are equal')
      }else{
        console.log('are not equal')
      }
    },

    init() {
      this.$watch('expanded', (value) => {
          console.log('sending this')
          console.log(this);
          if (value) {
              this.$dispatch('expand', this.$refs.expandable);
          }
      });
      console.log(this.$root);
      {{-- this.$root.addEventListener('expand', (event) => {
          console.log('handling:');
          console.log(event, event.detail, this);
          if(event.detail == this) {
            console.log('are equal')
          }

          if (event.detail !== this) {
              console.log('this is happening')
              this.expanded = false;
          }
      }); --}}
    }
  }"
@endif 
  >  
    <span 
        class="cursor-pointer relative"
        @click="expanded = !expanded">
        {{ $trigger }}
    </span>

    <ul
        x-show="expanded" x-collapse.duration.300ms
        {{ $attributes->class(['py-2 space-y-2']) }}
        >
        {{ $slot }}
    </ul>

</div>