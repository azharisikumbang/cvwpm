@extends('app')

@section('title', 'Tambah Gudang Baru')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-web.index') => 'Panel Web Admin',
route('admin-web.gudang.index') => 'Master Gudang',
route('admin-web.gudang.create') => 'Tambah Gudang Baru',
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
        @include('admin-web.gudang.form', ['action' => route('admin-web.gudang.store')])
    </div>
</div>
@endsection

@section('script')

@endsection