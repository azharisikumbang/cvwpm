<div class="flex justify-end gap-4">
    <a href="{{ $edit }}" class="hover:underline text-blue-600 hover:text-blue-700 focus:outline-none">Ubah
        Data</a>

    <div x-data="{ openModal: false }">
        <button x-on:click="openModal = true"
            class="hover:underline text-red-600 hover:text-red-700 focus:outline-none">Hapus</button>

        <!-- Modal -->
        <div x-show="openModal" style="display: none">

            <div class="fixed inset-0 flex items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-auto  z-50">
                    <h2 class="text-lg font-semibold mb-4">Mohon Konfirmasi</h2>
                    <p>Mengkonfirmasi penghapusan akan menghapus data selamanya. <br>Apakah anda
                        yakin ingin menghapus data ini?</p>
                    <div class="mt-6 flex justify-end">
                        <button x-on:click="openModal = false"
                            class="h-10 text-gray-500 hover:text-gray-700 focus:outline-none text-sm px-5 py-2.5">Batalkan</button>

                        <form method="POST" action="{{ $delete }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-red-700 bg-red-500 text-white">Hapus
                                Sekarang</button>
                        </form>
                    </div>
                </div>
                <div class="bg-gray-500 bg-opacity-50 fixed inset-0"></div>
            </div>
        </div>
    </div>
</div>