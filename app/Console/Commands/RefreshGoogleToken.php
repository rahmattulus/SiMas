<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RefreshGoogleToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:refresh-token';
    protected $description = 'Refresh Google Drive access token using the refresh token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => env('GOOGLE_DRIVE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refresh_token' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'grant_type' => 'refresh_token',
        ]);

        $data = $response->json();

        if (isset($data['access_token'])) {
            // Simpan token baru ke file atau cache
            Storage::put('google_access_token.json', json_encode($data));

            $this->info('Access token updated successfully.');
        } else {
            $this->error('Failed to refresh access token: ' . json_encode($data));
        }
    }
}
