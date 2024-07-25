<div class="flex-1 px-3 space-y-1">
    <ul class="pb-2 space-y-2">
        <li>
            <a href=""
                class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                <span class="ml-3" sidebar-toggle-item="">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin-stock.purchase-order.index') }}"
                class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                <span class="ml-3" sidebar-toggle-item="">Cek Aktivitas PO</span>
            </a>
        </li>
        <li>
            <a href=""
                class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                <span class="ml-3" sidebar-toggle-item="">Cek Aktivitas Sales</span>
            </a>
        </li>
        {{-- <li>
            <a href="{{ route('admin-stock.pengajuan-pembelian.index') }}"
                class="flex items-center p-2 text-base text-white rounded-lg hover:bg-blue-700 group hover:underline">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 21">
                    <path
                        d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                    <path
                        d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                </svg>
                <span class="ml-3" sidebar-toggle-item="">Pengajuan Pembelian</span>
            </a>
        </li> --}}
    </ul>
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Barang Masuk
        </div>

        <a href="{{ route('admin-stock.barang.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Catat Barang PO</span>
        </a>
    </div>
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Data Master
        </div>

        <a href="{{ route('admin-stock.barang.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Data Barang</span>
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
    </div>
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Pengaturan Akun
        </div>

        <a href="{{ route('user.profile.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 19">
                <path
                    d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z" />
            </svg><span class="ml-3" sidebar-toggle-item="">Perbaharui Profil</span>
        </a>
        <a href="{{ route('user.password.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 19">
                <path
                    d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z" />
            </svg><span class="ml-3" sidebar-toggle-item="">Ganti Password</span>
        </a>
        <form action="{{ route('authentication.logout') }}" method="post"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            @csrf

            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 19 16">
                <path
                    d="M12.5 3.046H10v-.928A2.12 2.12 0 0 0 8.8.164a1.828 1.828 0 0 0-1.985.311l-5.109 4.49a2.2 2.2 0 0 0 0 3.24L6.815 12.7a1.83 1.83 0 0 0 1.986.31A2.122 2.122 0 0 0 10 11.051v-.928h1a2.026 2.026 0 0 1 2 2.047V15a.999.999 0 0 0 1.276.961A6.593 6.593 0 0 0 12.5 3.046Z" />
            </svg>
            <button type="submit" class="hover:underline ml-3">Keluar</button>
        </form>
    </div>
</div>