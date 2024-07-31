<form method="POST" action="{{ $action }}" class="space-y-4 md:space-y-6">
    @csrf

    <div>
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            Nama Gudang</label>
        <input
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
            id="name" type="text" name="nama" required autofocus>
    </div>

    <div>
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            Kode Gudang</label>
        <input placeholder="cth: PDG, SLK, PPJ"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
            id="name" type="text" name="kode_gudang" required>
        <label for="" class="text-sm italic text-red-500">Kode gudang akan digunakan dalam kode produk.</label>
    </div>

    <div>
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            Lokasi</label>
        <input
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
            id="name" type="text" name="lokasi" required autofocus>
    </div>

    <div>
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            PIC Gudang</label>
        <select name="role_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 ">
            <option value>-- Tidak ada PIC --</option>
            @foreach ($listStaf as $staf)
            <option value="{{ $staf['id'] }}">{{ $staf['nama'] }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Simpan</button>
    </div>
</form>