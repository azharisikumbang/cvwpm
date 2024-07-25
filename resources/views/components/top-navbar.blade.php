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
            <div class="flex items-center gap-1 bg-white rounded shadow px-2 py-1 text-sm">
                <span class="flex  w-3 h-3 bg-green-500 rounded-full"></span>

                @if(auth()->user()->staf?->gudangKerja)
                <span>{{ auth()->user()->nama }}</span>
                @endif

                <span>/ {{ auth()->user()->jabatan }}</span>


            </div>
        </div>
    </div>
</nav>