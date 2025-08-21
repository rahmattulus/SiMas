<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected $googleDriveService;

    public function __construct(GoogleDriveService $googleDriveService)
    {
        $this->googleDriveService = $googleDriveService;
    }
    public function index()
    {
        // Ambil data Surat Masuk dan tambahkan kolom 'jenis'
        $suratMasuk = Surat::orderByDesc('created_at')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'no_surat' => $item->no_surat,
                'tanggal_surat' => $item->tanggal_surat,
                'tanggal_diterima' => $item->tanggal_diterima,
                'pengirim_tujuan' => $item->surat_dari,
                'perihal' => $item->perihal,
                'agenda' => $item->no_agenda,
                'status' => $item->status,
                'file_surat' => $item->file_surat,
                'jenis' => 'Surat Masuk'
            ];
        });

        $suratKeluar = SuratKeluar::orderByDesc('created_at')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'no_surat' => $item->no_surat,
                'tanggal_surat' => $item->tanggal_surat,
                'tanggal_diterima' => null,
                'pengirim_tujuan' => $item->tujuan,
                'perihal' => $item->perihal,
                'agenda' => $item->agenda,
                'status' => null,
                'file_surat' => $item->file_surat,
                'jenis' => 'Surat Keluar'
            ];
        });

        // Gabungkan data Surat Masuk dan Surat Keluar
        $surat = $suratMasuk->concat($suratKeluar)->sortByDesc('created_at');
        // $file_surat = Gdrive::get($surat['file_surat']);
        // Hitung jumlah surat masuk & keluar
        $totalSuratMasuk = $suratMasuk->count();
        $totalSuratKeluar = $suratKeluar->count();
        $suratSelesai = Surat::where('status', 'selesai')->count();

        // Hitung progres
        $progres = $totalSuratMasuk > 0 ? ($suratSelesai / $totalSuratMasuk) * 100 : 0;

        return view('home', compact('surat', 'totalSuratMasuk', 'totalSuratKeluar', 'suratSelesai', 'progres'));
    }

    public function showFile($jenis, $id)
    {
        // Perbarui token sebelum akses Google Drive
        // $this->googleDriveService->updateGoogleDriveConfig();

        if ($jenis === 'Surat Masuk') {
            $surat = Surat::find($id);
        } elseif ($jenis === 'Surat Keluar') {
            $surat = SuratKeluar::find($id);
        } else {
            return abort(400, 'Jenis surat tidak valid');
        }
        if (!$surat || !$surat->file_surat) {
            return abort(404, 'File tidak ditemukan');
        }

        $filePath = $surat->file_surat;

        if (!Storage::disk('google')->exists($filePath)) {
            return abort(404, 'File tidak ditemukan di Google Drive');
        }

        $data = Storage::disk('google')->get($filePath);
        $mimeType = Storage::disk('google')->mimeType($filePath) ?? 'application/octet-stream';

        return response($data, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . basename($filePath) . '"');
    }


    public function downloadFile($id)
    {

        $this->googleDriveService->updateGoogleDriveConfig();

        $surat = Surat::find($id) ?? SuratKeluar::find($id);

        if (!$surat || !$surat->file_surat) {
            return abort(404, 'File tidak ditemukan');
        }

        $filePath = $surat->file_surat;

        if (!Storage::disk('google')->exists($filePath)) {
            return abort(404, 'File tidak ditemukan di Google Drive');
        }

        return Storage::disk('google')->download($filePath);
    }



    // public function coba(){
    //     Storage::disk('google')->put('text.txt', 'Holla');

    //     return response()->json(['success' => true]);
    // }
}
