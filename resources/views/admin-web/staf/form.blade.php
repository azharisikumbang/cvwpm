<form method="POST" action="{{ $action }}" class="space-y-4 md:space-y-6">
    @csrf

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
        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
            Akun Akses Aplikasi</label>
        <select name="user_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 ">
            <option value selected disabled>-- Staf ini tidak perlu mengakses sistem --</option>
            @foreach ($listUser as $user)
            <option value="{{ $user['id'] }}">{{ $user['username'] }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Simpan</button>
    </div>
</form>