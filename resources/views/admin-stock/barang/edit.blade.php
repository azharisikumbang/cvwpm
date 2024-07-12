@extends('app')

@section('title', 'Edit Data Barang')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-stock.index') => 'Panel Admin Stok',
route('admin-stock.barang.index') => 'Data Master Barang',
"#" => 'Edit Data Barang'
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
        <form method="POST" action="{{ route('admin-stock.barang.update', ['barang' => $barang['id']]) }}"
            class="space-y-4 md:space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    Nama Barang</label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    type="text" name="nama" value="{{ old('nama', $barang['nama']) }}" required autofocus>
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900">
                    Satuan</label>
                <input list="satuan" value="{{ old('satuan', $barang['satuan']) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    type="text" name="satuan" placeholder="cth. pcs, kg, gram, ltr, dsb." required>

                <datalist id="satuan">
                    @foreach ($listSatuan as $satuan)
                    <option>{{ $satuan }}</option>
                    @endforeach
                </datalist>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">
                    Harga Satuan (Rupiah)</label>
                <input value="{{ old('harga', $barang['harga']) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    type="number" name="harga" min="0" step="1000" required>
            </div>

            <div>
                <button type="submit"
                    class="w-full text-white bg-orange-400 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Perbaharui</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

@endsection