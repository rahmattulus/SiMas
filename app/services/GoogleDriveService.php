<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
    public function getUpdatedAccessToken()
    {
        // Ambil access token terbaru dari file lokal
        $tokenData = json_decode(Storage::disk('local')->get('google_access_token.json'), true);
        return $tokenData['access_token'] ?? null;
    }
    public function updateGoogleDriveConfig()
    {
        // Set konfigurasi Google Drive dengan access token terbaru
        config(['filesystems.disks.google.token' => $this->getUpdatedAccessToken()]);
    }
}
