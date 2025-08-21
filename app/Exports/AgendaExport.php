<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AgendaExport implements WithMultipleSheets
{
    protected $bulan, $tahun, $jenis_surat;

    public function __construct($bulan, $tahun, $jenis_surat = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->jenis_surat = $jenis_surat;
    }

    public function sheets(): array
    {
        $sheets = [];

        if (!$this->jenis_surat || $this->jenis_surat === 'masuk') {
            $sheets['Surat Masuk'] = new SuratMasukSheet($this->bulan, $this->tahun);
        }

        if (!$this->jenis_surat || $this->jenis_surat === 'keluar') {
            $sheets['Surat Keluar'] = new SuratKeluarSheet($this->bulan, $this->tahun);
        }

        return $sheets;
    }
}
