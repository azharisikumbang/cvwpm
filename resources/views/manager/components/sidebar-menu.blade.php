<div class="flex-1 px-3 space-y-1">
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Laporan
        </div>

        <a href="{{ route('laporan-kartu-stok.index') }}"
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