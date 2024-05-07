@props([
    'columns'
])

<div {{ $attributes->class([
    'relative overflow-x-auto shadow-sm sm:rounded-lg'
]) }}>
    <table class="min-w-full table-fixed divide-y divide-gray-300 text-gray-800">
        <x-table.header :$columns />
        <tbody class="divide-y divide-gray-200 bg-white text-gray-700">
        {{ $slot }}
        </tbody>
    </table>
</div>