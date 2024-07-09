<nav class="w-full border-b border-gray-200 mb-2">
    <div class="py-2 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex">
                <span @click="toggleSidebar"
                    class="hover:bg-gray-200 flex items-center border rounded p-2 cursor-pointer">
                    <svg class="w-5" viewBox="0 0 20 20">
                        <path fill="gray"
                            d="M3.314,4.8h13.372c0.41,0,0.743-0.333,0.743-0.743c0-0.41-0.333-0.743-0.743-0.743H3.314
                                c-0.41,0-0.743,0.333-0.743,0.743C2.571,4.467,2.904,4.8,3.314,4.8z M16.686,15.2H3.314c-0.41,0-0.743,0.333-0.743,0.743
                                s0.333,0.743,0.743,0.743h13.372c0.41,0,0.743-0.333,0.743-0.743S17.096,15.2,16.686,15.2z M16.686,9.257H3.314
                                c-0.41,0-0.743,0.333-0.743,0.743s0.333,0.743,0.743,0.743h13.372c0.41,0,0.743-0.333,0.743-0.743S17.096,9.257,16.686,9.257z">
                        </path>
                    </svg>
                </span>
            </div>
            <div class="italic text-sm text-gray-400">
                <span>Login sebagai {{ auth()->user()->username }}</span>
                -
                <span class="hover:text-red-800 hover:underline text-red-500 cursor-pointer"
                    @click="window.location.reload()">muat ulang halaman</span>
            </div>
        </div>
    </div>
</nav>