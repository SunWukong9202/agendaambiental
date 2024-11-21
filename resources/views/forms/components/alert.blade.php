<div 
x-data="{open: {{ json_encode($getOpen()) }}}"
{{ $attributes->class([
    'border-l-4 p-4 font-normal rounded-sm',
    'bg-orange-50 border-orange-300 text-orange-500 dark:bg-orange-900 dark:border-orange-700 dark:text-orange-300' => $getType() == 'Warning',
    'bg-blue-50 border-blue-300 text-blue-500 dark:bg-blue-900 dark:border-blue-700 dark:text-blue-300' => $getType() == 'Info',
    'bg-danger-50 border-danger-300 text-danger-600 dark:bg-danger-900 dark:border-danger-700 dark:text-danger-300' => $getType() == 'Danger',
    'bg-green-50 border-green-300 text-green-600 dark:bg-green-900 dark:border-green-700 dark:text-green-300' => $getType() == 'Success',
]) }}

{{-- class="rounded-sm"  --}}
role="alert">
        
    <div @click="open = !open" class="flex items-center justify-between py-2" >
        <p class="font-semibold flex-grow cursor-pointer">
            {{ $getTitle() }}
        </p>
        
        <x-heroicon-m-chevron-down 
            class="w-4 h-4" 
            x-bind:class="open ? '-rotate-180' : 'rotate-0'"
        />
    </div>


    <div x-show="open" class="text-sm">
        <p 
            class="text-sm"
        >
            {{ $getDescription() }}
        </p>
    
        {{ $getChildComponentContainer() }}
    
        <ul  @class([
            'list-disc mt-2 space-y-2 ps-5' => count($getList()) > 0
        ])">
            @foreach ($getList() as $option)
            <li>
                {{ $option }}
            </li>
            @endforeach
        </ul>
    </div>
  </div>
