

<button 
{{ $attributes->class([
    //base
    'ms-auto h-8 w-8 p-1.5 -mx-1.5 -my-1.5 rounded-lg',
    //alignment
    'inline-flex items-center justify-center',
    //decoration
    'bg-white text-gray-400 hover:text-gray-900 hover:bg-gray-100',
    //focus styles
    'focus:ring-2 focus:ring-gray-300',
    //dark styles
    'dark:text-gray-500 dark:hover:text-white  dark:bg-gray-800 dark:hover:bg-gray-700'
]) }}
type="button">
    {{ $slot }}
</button>