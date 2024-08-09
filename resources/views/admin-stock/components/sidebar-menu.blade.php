<div class="flex-1 px-3 space-y-1">
    <ul class="pb-2 space-y-2">
        <li>
            <a href="{{ route('admin-stock.barang.index') }}"
                class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
                <span class="ml-3" sidebar-toggle-item="">Data Barang</span>
            </a>
        </li>
    </ul>
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Barang Masuk
        </div>

        <a href="{{ route('admin-stock.purchase-order.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Barang Masuk PO</span>
        </a>

        <a href="{{ route('admin-stock.pindah-gudang-tujuan.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Pindah Gudang</span>
        </a>
    </div>

    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Barang Keluar
        </div>

        <a href="{{ route('admin-stock.sales-canvas.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Sales Canvas</span>
        </a>

        <a href="{{ route('admin-stock.pindah-gudang.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Pindah Gudang</span>
        </a>
    </div>

    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Laporan
        </div>

        <a href="{{ route('admin-stock.kartu-stok.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Kartu Stok</span>
        </a>

        <a href="{{ route('laporan-persediaan.create') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Persediaan</span>
        </a>
    </div>

    @include('components.nav-user-settings')
</div>