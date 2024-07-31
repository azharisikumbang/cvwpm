<div class="flex-1 px-3 space-y-1">
    <div class="pt-2 space-y-2">
        <div class="text-white font-bold uppercase">
            Data Master
        </div>

        <a href="{{ route('admin-web.gudang.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Data Gudang</span>
        </a>

        <a href="{{ route('admin-web.staf.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Data Staf</span>
        </a>

        <a href="{{ route('admin-web.users.index') }}"
            class="flex items-center p-2 text-base text-white transition duration-75 rounded-lg hover:bg-blue-700 group hover:underline ">
            <span class="ml-3" sidebar-toggle-item="">Akun Aplikasi</span>
        </a>
    </div>

    @include('components.nav-user-settings')
</div>