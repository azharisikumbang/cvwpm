<div class="flex-1 px-3 space-y-1">
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Aktivitas
        </div>

        <ul class="pb-2 space-y-2">
            <li>
                <a href="{{ route('sales.penjualan.index') }}"
                    class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                    <span class="ml-3">Catat Penjualan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('sales.canvas.index') }}"
                    class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                    <span class="ml-3">Riwayat Canvas</span>
                </a>
            </li>
        </ul>
    </div>

    @include('components.nav-user-settings')
</div>