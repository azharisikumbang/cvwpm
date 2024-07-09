@extends('app')

@section('title', 'Pengelolaan Profil Pengguna')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-web.index') => 'Dashboard',
route('user.profile.index') => 'Pengelolaan Profil Pengguna'
]])
@endsection

@section('alert')
{{-- @include('components.alert', ['color' => 'red', 'message' => 'test']) --}}
@endsection

@section('content')
<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-600 md:text-2xl">
        Perbaharui Profile
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
        <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-4 md:space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                    Nama Lengkap</label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    id="name" type="text" name="name" value="{{ $user['name'] }}" required autofocus>
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="email">
                    Email</label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    id="email" type="email" name="email" value="{{ $user['email'] }}" required>
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="username">
                    Username <small class="italic text-gray-400">(tidak dapat dirubah)</small></label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    id="username" type="text" value="{{ $user['username'] }}" disabled>
            </div>

            <div>
                <label class=" block mb-2 text-sm font-medium text-gray-900" for="email">
                    Tugas akun <small class="italic text-gray-400">(tidak dapat dirubah)</small></label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                    type="text" value="{{ $user['role']['displayble_name'] }}" disabled>
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