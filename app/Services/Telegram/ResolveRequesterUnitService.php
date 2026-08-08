<?php

namespace App\Services\Telegram;

use App\Models\RequesterUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResolveRequesterUnitService
{
    public function execute(string $name): RequesterUnit
    {
        $name = trim($name);

        $requester = RequesterUnit::query()
            ->where('aktif', true)
            ->whereRaw('LOWER(nama) = ?', [mb_strtolower($name)])
            ->first();

        if (!$requester) {
            throw new ModelNotFoundException(
                "Requester unit '{$name}' tidak ditemukan."
            );
        }

        return $requester;
    }
}