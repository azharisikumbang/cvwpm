@extends('app')

@section('title', 'Tambah Data Toko')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-web.index') => 'Panel Admin Stok',
route('admin-stock.toko.index') => 'Data Master Toko',
'#' => 'Tambah Toko Baru',
]])
@endsection

@section('content')
<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-600 md:text-2xl mb-2">
        @yield('title')
    </h1>

    @session('success')
    <div class="sm:max-w-md w-full">
        <x-alert color="green" :message="$value" />
    </div>
    @endsession

    @if ($errors->any())
    <div class="sm:max-w-md w-full">
        @foreach ($errors->all() as $error)
        <x-alert color="yellow" :message="$error" />
        @endforeach
    </div>
    @endif

    <div class="max-w-md">
        <form method="POST" action="{{ route('admin-stock.toko.update', ['toko' => $toko['id']]) }}"
            class="space-y-4 md:space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    Nama Toko</label>
                <input value="{{ old('nama', $toko['nama']) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    type="text" name="nama" required autofocus>
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    Alamat Toko</label>
                <textarea rows="5"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    name="alamat">{{ old('alamat', $toko['alamat']) }}
                </textarea>
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    CP <small class="italic text-gray-400">(opsional)</small></label>
                <input value="{{ old('cp', $toko['cp']) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    type="text" name="cp">
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    UP <small class="italic text-gray-400">(opsional)</small></label>
                <input value="{{ old('up', $toko['up']) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    type="text" name="up">
            </div>

            <div>
                <button type="submit"
                    class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

@endsection