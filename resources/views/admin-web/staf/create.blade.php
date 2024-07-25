@extends('app')

@section('title', 'Tambah Staf Baru')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-web.index') => 'Panel Web Admin',
route('admin-web.staf.index') => 'Master Staf',
route('admin-web.staf.create') => 'Tambah Staf Baru',
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
        @include('admin-web.staf.form', ['action' => route('admin-web.staf.store')])
    </div>
</div>
@endsection

@section('script')

@endsection