@use('App\Enums\Permission')
@use('App\Enums\Role')
<x-slot:title>
    {{  __('ui.pages.Dashboard')  }}
</x-slot>
<div class="text-black text-lg"> 
<style>
    .masonry {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      grid-auto-rows: 150px;
      grid-auto-flow: dense;
      gap: 1rem;
    }
    .masonry > * {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 1rem;
      border-radius: 0.75rem;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .masonry > *:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
</style>
<main class="flex-1 p-6 max-w-full">
    <div class="text-center mb-8 text-gray-600 dark:text-gray-400">
      <h2 class="text-3xl font-semibold mb-2">
        {{  trans_choice('Welcome', auth()->user()->gender === 'female' ? 1 : 0) }}! {{ auth()->user()->name ?? '' }}
      </h2>
      <p>
        {{ __('Your dashboard is currently empty. Explore the sections:') }}
      </p>
    </div>

    <div class="masonry">
      <a href="{{ route('admin.users') }}" wire:navigate class="bg-indigo-300 dark:bg-indigo-700 row-span-2 col-span-1 w-full">
        <h3 class="text-lg font-bold mb-2">
          {{ __('ui.pages.Manage Users') }}
        </h3>
        <p class="text-gray-700 dark:text-gray-200 text-sm">
          {{ __('See More') }}
        </p>
      </a>

      <a href="{{ route('admin.suppliers') }}" wire:navigate class="bg-primary-300 dark:bg-primary-500 row-span-1 col-span-2 w-full">
        <h3 class="text-lg font-bold mb-2">
          {{ __('ui.pages.Manage Suppliers') }}
        </h3>
        <p class="text-gray-700 dark:text-gray-200 text-sm">
          {{ __('See More') }}
        </p>
      </a>

      <a href="{{ route('admin.events.actived') }}" wire:navigate class="bg-pink-300 dark:bg-pink-700 row-span-1 col-span-1 w-full">
        <h3 class="text-lg font-bold mb-2">
          {{ __('ui.pages.Active Events') }}
        </h3>
        <p class="text-gray-700 dark:text-gray-200 text-sm">
          {{ __('See More') }}
        </p>
      </a>

      <a href="{{ route('admin.events.wastes') }}" wire:navigate class="bg-blue-300 dark:bg-blue-700 row-span-1 col-span-1 w-full">
        <h3 class="text-lg font-bold mb-2">
          {{ __('ui.pages.Waste Managment') }}
        </h3>
        <p class="text-gray-700 dark:text-gray-200 text-sm">
          {{ __('See More') }}
        </p>
      </a>

    </div>
  </main>

</div>
