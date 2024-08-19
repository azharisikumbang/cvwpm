<?php

namespace Contracts\DTOs\Domain;

interface GudangDTO
{
    public function getId(): int;
    
    public function getKodeGudang(): string;

    public function getNamaGudang(): string;

    public function getLokasiGudang(): string;

    public function getPenanggungJawabGudang(): string;

    public function getNomorTeleponPenanggungJawab(): string;
}