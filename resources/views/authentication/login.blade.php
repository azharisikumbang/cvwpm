@extends('guest')

@section('content')
<div class="bg-gray-200 flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    @if ($errors->any())
    <div class="sm:max-w-md w-full">
        @foreach ($errors->all() as $error)
        <x-alert color="yellow" :message="$error" />
        @endforeach
    </div>
    @endif

    <div class="w-full bg-white rounded-lg shadow sm:max-w-md p-6">
        <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-800 md:text-2xl">
            Silahkan Login
        </h1>
        <form method="POST" action="{{ route('authentication.authenticate') }}" class="space-y-4 md:space-y-6">
            @csrf

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="username">
                    Username</label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    id="username" type="username" name="username" required autofocus>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900" for="password">Password</label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    id="password" type="password" name="password" required>
            </div>

            <div>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </div>

            <div>
                <button type="submit"
                    class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Login</button>
            </div>
        </form>
    </div>

    <div class="mt-4 sm:max-w-lg">
        <h2 class="font-bold">Perhatian! </h2>
        <p>Informasi yang terkandung pada website ini adalah bukan sebernarnya, hanya diperuntukkan sebagai uji coba.
        </p>
        <h2 class="font-bold">Akun Akses!</h2>
        <p>Gunakan username di bawah sesuai hak akses nya. Semua password adalah sama. (password:
            <strong>12345678</strong>)
        </p>
        <ul class="list-disc list-inside">
            <li><b>admin</b> (Web Admin)</li>
            <li><b>manager</b> (Manager)</li>
            <p>&nbsp;</p>
            <li><b>stockpadang</b> (Admin Stok Padang)</li>
            <li><b>purchasingpadang</b> (Admin Purchasing Padang)</li>
            <li><b>salespadang</b> (Sales Padang)</li>
            <p>&nbsp;</p>
            <li><b>stocksolok</b> (Admin Stok solok)</li>
            <li><b>purchasingsolok</b> (Admin Purchasing solok)</li>
            <li><b>salessolok</b> (Sales solok)</li>
        </ul>
    </div>
</div>
@endsection