<div class="flex-1 px-3 space-y-1">
    <ul class="pb-2 space-y-2">
        <li>
            <a href="{{ route('sales.index') }}"
                class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                <span class="ml-3" sidebar-toggle-item="">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('sales.penjualan.index') }}"
                class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                <span class="ml-3">Tambah Penjualan</span>
            </a>
        </li>

        <li>
            <a href="{{ route('sales.canvas.index') }}"
                class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                <span class="ml-3">Riwayat Canvas</span>
            </a>
        </li>
    </ul>

    @include('components.nav-user-settings')
</div>