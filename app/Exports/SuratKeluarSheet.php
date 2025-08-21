<?php

namespace App\Exports;

use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SuratKeluarSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function title(): string
    {
        return 'Surat Keluar'; // Ganti dengan nama yang diinginkan
    }

    private function extractGoogleDriveFileId($filePath)
    {
        // Cek apakah $filePath null atau kosong
        if (empty($filePath)) {
            return null;
        }

        if (!Storage::disk('google')->exists($filePath)) {
            return null;
        }

        // Ambil metadata dari Google Drive
        $metadata = Storage::disk('google')->getAdapter()->getMetadata($filePath);

        // Periksa apakah 'id' ada dalam metadata
        return $metadata['id'] ?? ($metadata['extraMetadata']['id'] ?? null);
    }


    public function map($item): array
    {
        $filePath = $item->file_surat ?? null;
        $fileId = $this->extractGoogleDriveFileId($filePath);

        $fileLink = $fileId
            ? 'https://drive.google.com/file/d/' . $fileId . '/view' // View tanpa download
            : 'Tidak Ada File';

        return [
            $item->agenda,
            $item->tujuan,
            $item->no_surat,
            $item->tanggal_surat,
            $item->pengolah_surat,
            $item->perihal,
            $item->lain_lain,
            $fileLink // Menyimpan link di Excel
        ];
    }

    public function collection()
    {
        $query = SuratKeluar::query();

        if ($this->bulan) {
            $query->whereMonth('tanggal_surat', $this->bulan);
        }
        if ($this->tahun) {
            $query->whereYear('tanggal_surat', $this->tahun);
        }

        $data = $query->select(
            'agenda',
            'tujuan',
            'no_surat',
            'tanggal_surat',
            'pengolah_surat',
            'perihal',
            'lain_lain',
            'file_surat',
        )->get();

        return $data;
    }

    public function headings(): array
    {
        return ['No. Agenda', 'Penerima', 'Nomor Surat', 'Tanggal Surat', 'Pengolah Surat', 'Perihal', 'Lain-lain', 'File'];
    }
}
