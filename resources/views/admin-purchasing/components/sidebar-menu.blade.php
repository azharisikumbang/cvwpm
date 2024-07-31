<div class="flex-1 px-3 space-y-1">
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Aktivitas
        </div>

        <a href="{{ route('admin-purchasing.purchase-orders.create') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Catat PO</span>
        </a>

        <a href="{{ route('admin-purchasing.purchase-orders.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Riwayat PO</span>
        </a>
    </div>
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Pengaturan Akun
        </div>

        <a href="{{ route('user.profile.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Perbaharui Profil</span>
        </a>
        <a href="{{ route('user.password.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Ganti Password</span>
        </a>
        <form action="{{ route('authentication.logout') }}" method="post"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            @csrf
            <button type="submit" class="hover:underline ml-3">Keluar</button>
        </form>
    </div>
</div>