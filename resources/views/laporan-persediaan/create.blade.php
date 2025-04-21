@extends('app')

@section('title', 'Laporan Persediaan')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('manager.home') => 'Panel Manajemen',
route('manager.laporan-persediaan.create') => 'Laporan Persediaan',
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

    <div x-data="data">
        <form method="POST" action="{{ route('laporan-persediaan.show') }}" class="w-full">
            @csrf

            <div class="flex justify-between w-full gap-8">
                <div class="w-1/3 space-y-4 md:space-y-6 ">
                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Gudang Penyimpanan
                        </label>
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            name="gudang" required>
                            <option value selected disabled>-- pilih gudang penyimpanan --</option>
                            @foreach ($listGudang as $gudang)
                            <option value="{{ $gudang['id'] }}">{{ $gudang['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Cek
                    Persediaan</button>
            </div>
        </form>
    </div>
</div>
@endsection