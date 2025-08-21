<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JeroenNoten\LaravelAdminLte\Http\Controllers\Controller;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class suratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suratKl = SuratKeluar::all();
        return view('suratKeluar.index', compact('suratKl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $agenda = SuratKeluar::max('agenda');
        $default_agenda = $agenda ? intval($agenda) + 1 : 1;
        return view('suratKeluar.create', compact('default_agenda'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'agenda' => 'required',
            'tanggal_surat' => 'required',
            'tujuan' => 'required',
        ]);

        // Logic "File Surat"
        if ($request->hasFile('file_surat')) {
            $noAgenda = $request->agenda ?? 'agenda';
            $suratDari = preg_replace('/[^a-z0-9_]/i', '_', strtolower($request->tujuan ?? 'unknown'));
            $extension = $request->file('file_surat')->getClientOriginalExtension();
            $filename = $noAgenda . '_' . $suratDari . '.' . $extension;

            // Path folder berdasarkan Tahun dan Bulan
            $year = date('Y');
            $month = date('F'); // Contoh: "March"
            $folderPath = "Surat Keluar/$year/$month/"; // Pastikan format path benar
            $filePath = $folderPath . $filename; // Complete path including filename

            // Baca isi file
            $fileContents = file_get_contents($request->file('file_surat')->getRealPath());

            // Save to Google Drive with file contents
            Storage::disk('google')->put($filePath, $fileContents);
        }

        // dd($filePath);

        $surat = SuratKeluar::create([
            'agenda' => $request->agenda,
            'tanggal_surat' => $request->tanggal_surat,
            'tujuan' => $request->tujuan,
            'pengolah_surat' => $request->pengolah_surat ?? null,
            'no_surat' => $request->no_surat ?? null,
            'perihal' => $request->perihal ?? null,
            'lain_lain' => $request->lain_lain ?? null,
            'file_surat' => $filePath ?? null,
        ]);

        // dd($surat);

        return redirect()->route('suratKeluar.index')->with('success', 'Surat berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratKeluar $suratKeluar)
    {
        //
        return view('suratKeluar.show', compact('suratKeluar'));
    }

    public function viewFile(SuratKeluar $surat)
    {
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
    public function edit(string $id)
    {
        //
        $suratKeluar = SuratKeluar::findOrFail($id);
        return view('suratKeluar.edit', compact('suratKeluar'));
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
        //
        $suratKl = SuratKeluar::findOrFail($id);

        if ($suratKl->file_surat) {
            Gdrive::delete($suratKl->file_surat);
        }
        $suratKl->delete();
        return redirect()->route('suratKeluar.index')->with('success', 'Berhasil dihapus');
    }
}
