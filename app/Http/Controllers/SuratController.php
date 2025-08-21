<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use JeroenNoten\LaravelAdminLte\Http\Controllers\Controller;


class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $googleDriveService;

    public function __construct(GoogleDriveService $googleDriveService)
    {
        $this->googleDriveService = $googleDriveService;
    }
    public function index()
    {
        $surat = Surat::all();
        $suratMasuk = $surat->count();
        $suratSelesai = Surat::where('status', 'selesai')->count();
        $progres = $suratMasuk > 0 ? ($suratSelesai / $suratMasuk) * 100 : 0;

        return view('suratMasuk.index', compact('surat', 'suratMasuk', 'suratSelesai', 'progres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Logika No Agenda
        // $agenda = Surat::latest('id')
        //     ->first();
        $agenda = Surat::max('no_agenda');
        $default_agenda = $agenda ? intval($agenda) + 1 : 1;

        return view('suratMasuk.create', compact('default_agenda'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $this->googleDriveService->updateGoogleDriveConfig();
        // Validasi data input
        $request->validate([
            'surat_dari' => 'required',
            'tanggal_surat' => 'required',
            'tanggal_diterima' => 'required',
            'no_agenda' => 'required',
        ]);

        // Logic "Ditujukan"
        $ditujukan = $request->input('ditujukan', []);
        $final_ditujukan = [];
        foreach ($ditujukan as $item) {
            // Simpan jika checkbox dicentang atau teks tambahan diisi
            if (!empty($item['value']) || !empty($item['tambahan'])) {
                $value = $item['value'] ?? ''; // Gunakan nilai checkbox (jika ada)
                if (!empty($item['tambahan'])) {
                    $value .= ' (' . $item['tambahan'] . ')'; // Tambahkan teks tambahan
                }
                $final_ditujukan[] = $value; // Masukkan ke array final
            }
        }

        //Logic "Respon"
        $respon = $request->input('respon', []);
        $final_respon = [];
        foreach ($respon as $res) {
            if (!empty($res['harap']) || !empty($res['lainnya'])) {
                $harap = $res['harap'] ?? '';
                if (!empty($res['lainnya'])) {
                    $harap .= '(' . $res['lainnya'] . ')';
                }
                $final_respon[] = $harap;
            }
        }

        // Logic "File Surat"
        if ($request->hasFile('file_surat')) {
            $noAgenda = $request->no_agenda ?? 'no-agenda';
            $suratDari = preg_replace('/[^a-z0-9_]/i', '_', strtolower($request->surat_dari ?? 'unknown'));
            $extension = $request->file('file_surat')->getClientOriginalExtension();
            $filename = $noAgenda . '_' . $suratDari . '.' . $extension;

            // Path folder berdasarkan Tahun dan Bulan
            $year = date('Y');
            $month = date('F'); // Contoh: "March"
            $folderPath = "Surat Masuk/$year/$month/"; // Pastikan format path benar
            $filePath = $folderPath . $filename; // Complete path including filename

            // Baca isi file
            $fileContents = file_get_contents($request->file('file_surat')->getRealPath());

            // Save to Google Drive with file contents
            Storage::disk('google')->put($filePath, $fileContents);
        }



        // Log::info("Nama file yang akan disimpan ke database: " . ($uploadedFile ?? 'NULL'));

        Surat::create([
            'surat_dari' => $request->surat_dari,
            'no_surat' => $request->no_surat ?? null,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_diterima' => $request->tanggal_diterima,
            'perihal' => $request->perihal ?? null,
            'sifat' => $request->sifat ?? null,
            'no_agenda' => $request->no_agenda,
            'ditujukan' => json_encode($final_ditujukan) ?? null,
            'respon' => json_encode($final_respon) ?? null,
            'catatan' => $request->catatan ?? null,
            'file_surat' => $filePath ?? null,
            'status' => $request->status,
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        // dd($surat);
        return view('suratMasuk.show', compact('surat'));
    }

    public function viewFile(Surat $surat)
    {
        
        $this->googleDriveService->updateGoogleDriveConfig();
        // dd($surat->file_surat);
        if (!$surat->file_surat) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = $surat->file_surat; // Pastikan ini hanya ID file, bukan path lengkap

        try {
            $data = Storage::disk('google')->get($filePath);
            $mimeType = Storage::disk('google')->mimeType($filePath) ?? 'application/octet-stream';

            return response($data, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $filePath . '"');
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat mengambil file.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $surat = Surat::findOrFail($id);
        $ditujukan = json_decode($surat->ditujukan, true); // Decode untuk array PHP
        $respon = json_decode($surat->respon, true);
        // dd($ditujukan);
        return view('suratMasuk.edit', compact('surat', 'ditujukan', 'respon'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $this->googleDriveService->updateGoogleDriveConfig();
        //
        $surat = Surat::findOrFail($id);

        // dd($surat->file_surat);
        if ($surat->file_surat) {
            Gdrive::delete($surat->file_surat);
        }
        $surat->delete();
        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus');
    }

    public function updateStatus($id, $status)
    {
        // Validasi status yang diterima
        if (!in_array($status, ['selesai'])) {
            return redirect()->route('surat.index')->with('error', 'Status tidak valid');
        }

        // Temukan data berdasarkan ID
        $surat = Surat::findOrFail($id);

        // var_dump($surat);

        // Perbarui status
        $surat->update([
            'status' => $status,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('surat.index')->with('success', 'Status berhasil diperbarui.');
    }
}
