@props([
    'columns'
])


<thead>
    <tr>
        @foreach ($columns as $column => $sortable)
        @if (!is_array($sortable))
        <th class="p-3 text-left text-sm font-semibold text-gray-900">
            <div>
                {{ $sortable }}
            </div>
        </th>
        @else
        <th class="p-3 text-left text-sm font-semibold text-gray-900">

        <x-button.sortable 
        :column="$sortable[0]"
        :sortCol="$sortable[1]" 
        :sortAsc="$sortable[2]"
        >
                <div>
                    {{ $column }}
                </div>
        </x-button> 
        </th>
        @endif
        @endforeach
    </tr>
</thead>
