<div class="flex flex-col gap-8">
    <div class="grid grid-cols-8 gap-2 ">
        <div class="relative text-sm text-gray-800 col-span-3">
            <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
        </div>

        <div class="flex gap-2 justify-end col-span-5">
            <div class="flex">
                <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
            </div>
        </div>
    </div>

    <div>
        <div class="relative animate-pulse w-full">
            <div class="p-3">
                <div class="w-full bg-gray-100 rounded-lg">&nbsp;</div>
            </div>

            <table class="min-w-full table-fixed divide-y divide-gray-300 text-gray-800">
                <tbody class="divide-y divide-gray-200 bg-white text-gray-700">
                    @foreach (range(0, $howMany) as $i)
                        <tr>
                            @foreach (range(0, $cols) as $j)
                                <td class="whitespace-nowrap p-3 text-sm">
                                    <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>