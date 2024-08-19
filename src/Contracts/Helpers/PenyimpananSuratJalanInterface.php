<?php

namespace Contracts\Helpers;

interface PenyimpananSuratJalanInterface
{
    public function simpan($file): void;

    public function getFullPath(): string;
}