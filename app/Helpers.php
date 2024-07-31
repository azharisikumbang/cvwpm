<?php

if (!function_exists('format_rupiah'))
{
    function format_rupiah($number)
    {
        return 'Rp ' . format_ribuan($number);
    }
}

if (!function_exists('format_ribuan'))
{
    function format_ribuan($number)
    {
        return number_format($number, 0, ',', '.');
    }
}

if (!function_exists('format_tanggal'))
{
    function format_tanggal($tanggal)
    {
        return \Carbon\Carbon::parse($tanggal)->format('d/m/Y');
    }
}

if (!function_exists('format_tanggal_indonesia'))
{
    function format_tanggal_indonesia($tanggal)
    {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return sprintf("%d %s %d", date('d', strtotime($tanggal)), $bulan[date('n', strtotime($tanggal))], date('Y', strtotime($tanggal)));
    }
}