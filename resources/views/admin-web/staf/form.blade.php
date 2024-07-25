<form method="POST" action="{{ $action }}" class="space-y-4 md:space-y-6">
    @csrf

    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Perhatian!</span> Jika staf diinginkan dapat mengakses sistem, setelah menambahkan
            data staf silahkan ke menu 'Akun Aplikasi' untuk mendaftarkan akun
        </div>
    </div>

    <div>
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            Nama Staf</label>
        <input
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
            id="name" type="text" name="nama" required autofocus>
    </div>

    <div>
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            Kontak</label>
        <input
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
            id="name" type="text" name="kontak" required autofocus>
    </div>

    <div>
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            Jabatan</label>
        <select name="jabatan"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 ">
            <option value selected disabled>-- Jabatan --</option>
            @foreach ($listJabatan as $jabatan)
            <option value="{{ $jabatan['id'] }}">{{ $jabatan['displayble_name'] }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            Gudang Kerja</label>
        <select name="gudang_kerja"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 ">
            <option value selected disabled>-- Pilih gudang staf bekerja --</option>
            @foreach ($listGudang as $gudang)
            <option value="{{ $gudang['id'] }}">{{ $gudang['nama'] }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Simpan</button>
    </div>
</form>