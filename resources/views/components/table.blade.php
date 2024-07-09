<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th>No</th>
                @foreach ($headers as $header)
                <th scope="col" class="px-6 py-3">
                    {{ $header }}
                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($items->items() as $item)
            <tr>
                <td class="px-6 py-4">
                    {{ $loop->index + 1 }}
                </td>
            </tr>
            @empty
            <tr>
                <td class="px-6 py-4 text-center" colspan="{{ count($headers) + 1 }}">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>