@extends('app')

@section('title', 'Page Title')

@section('content')
<div>
    <h2 class="text-xl">Selamat Datang</h2>
    <p class="mb-2">
        Halo, {{ auth()->user()->staf->nama }} ! Kamu masuk sebagai {{ auth()->user()->jabatan }} di {{
        auth()->user()->staf->gudangKerja->nama }}.
    </p>
    <p>Sekarang : {{ format_tanggal_indonesia(now()) . ' ' . date('H:i T') }}</p>
</div>
@endsection

@section('script')

@endsection