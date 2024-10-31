<nav 
x-data="{count: 0}"
{{ $attributes->class([
  'w-full bg-white shadow-sm dark:bg-gray-800 h-16 lg:h-20'
]) }}
>
  <div class="px-4 sm:px-8 py-3">
      <div class="flex items-center justify-start rtl:justify-end">
        <button 
        x-on:click="$dispatch('open-sidebar', 'sidebar-btn')"  
        type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100">
            <span class="sr-only">Open sidebar</span>
            <x-heroicon-m-bars-3 class="size-6" />
        </button>
    
        {{ $slot }}
    </div>
</nav>


{{-- <nav 
{{ $attributes->class([
  'w-full bg-white shadow-sm dark:bg-gray-800 h-16 lg:h-20'
]) }}
>
  <div class="px-4 sm:px-8 py-3">
      <div class="flex items-center justify-start rtl:justify-end">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <x-icon.bars />
        </button>
        
        {{ $slot }}
    </div>
</nav> --}}