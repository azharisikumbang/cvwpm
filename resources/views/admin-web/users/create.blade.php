@extends('app')

@section('title', 'Tambah Akun Staf Baru')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-web.index') => 'Panel Web Admin',
route('admin-web.users.index') => 'Data Pengguna',
route('admin-web.users.create') => 'Tambah Akun Staf Baru',
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
        <form method="POST" action="{{ route('admin-web.users.store') }}" class="space-y-4 md:space-y-6">
            @csrf

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    Pilih Staf Pemilik Akun</label>
                <select name="staf"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 ">
                    <option selected value disabled>-- pilih staf --</option>
                    @foreach ($staf as $data)
                    <option value="{{ $data['id'] }}">
                        {{ $data['nama'] }} /
                        {{ $data['gudang_kerja']['nama'] }} /
                        {{ $data['jabatan'] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    Username Akun</label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    id="name" type="text" name="username" required>
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    Password <small class="italic text-gray-400">(min: 8 karakter)</small></label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    id="name" type="password" name="password" required>
            </div>


            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    Ketik ulang password <small class="italic text-gray-400">(min: 8 karakter)</small></label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    id="name" type="password" name="password_confirmation" required>
            </div>

            <div>
                <button type="submit"
                    class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Perbaharui</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

@endsection