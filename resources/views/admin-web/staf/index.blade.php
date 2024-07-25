@extends('app')

@section('title', 'Master Staf')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-web.index') => 'Panel Web Admin',
route('admin-web.staf.index') => 'Master Staf',
]])
@endsection

@section('content')
<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-600 md:text-2xl mb-2">
        @yield('title')
    </h1>

    @session('success')
    <div class="w-full">
        <x-alert color="green" :message="$value" />
    </div>
    @endsession

    <div class="w-full">
        @include('components.table-search-and-create-button', [
        'search' => route('admin-web.staf.index'),
        'create' => route('admin-web.staf.create'),
        'label' => 'Tambah Data Staf'
        ])

        <table class="table-content">
            <thead>
                <tr>
                    <th style="width: 24px">No</th>
                    <th>Nama Staf</th>
                    <th>Jabatan</th>
                    <th>Gudang Kerja</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items['data'] as $staf)
                <tr>
                    <td style="text-align: center">{{ $loop->index + 1 }}</td>
                    <td style="text-align: left">{{ $staf['nama'] }} / {{ $staf['kontak'] }}</td>
                    <td style="text-align: center">{{ $staf['jabatan'] }}</td>
                    <td style="text-align: center">{{ $staf['gudang_kerja_text'] }}</td>
                    <td>
                        @include('components.table-action-button', [
                        'edit' => route('admin-web.staf.edit', ['staf' => $staf['id']]),
                        'delete' => route('admin-web.staf.destroy', ['staf' => $staf['id']]),
                        ])
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="6">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @include('components.table-footer-navigation', [
        'total' => $items['total'],
        'prev_page_url' => $items['prev_page_url'],
        'next_page_url' => $items['next_page_url'],
        ])

    </div>
</div>
@endsection

@section('script')

@endsection