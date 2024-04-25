@props([
    'key' => 'expanded'
])

<div x-data="{ expanded: $persist(false).as('{{ $key }}').using(sessionStorage) }">
    <span 
        class="cursor-pointer relative"
        @click="expanded = !expanded">
        {{ $trigger }}
    </span>

    <ul
        x-show="expanded" x-collapse.duration.400ms 
        class="py-2 space-y-2"
        >
        {{ $slot }}
        {{-- <li>
            <a
              href="#"
              class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
              >Settings</a
            >
          </li>
          <li>
            <a
              href="#"
              class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
              >Kanban</a
            >
          </li>
          <li>
            <a
              href="#"
              class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
              >Calendar</a
            >
          </li> --}}
    </ul>

</div>