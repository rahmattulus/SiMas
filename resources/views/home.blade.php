@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', '')
@section('content_header_title', 'Beranda')
@section('content_header_subtitle', '')

{{-- Content body: main page content --}}

@section('content_body')
<div class="card p-3">
    <div class="row pt-3">
        <div class="col-lg-4 col-md-6">
            <x-adminlte-info-box title="Surat Masuk" text="{{$totalSuratMasuk}}" icon="fas fa-envelope-open-text" theme="info" progress="" />
        </div>
        <div class="col-lg-4 col-md-6">
            <x-adminlte-info-box title="Telah ditindaklanjuti" text="{{$suratSelesai}}/{{$totalSuratMasuk}}" icon="far fa-lg fa-check-square " theme="primary" :progress="$progres" progress-theme="light" description="" />
        </div>
        <div class="col-lg-4 col-md-6">
            <x-adminlte-info-box title="Surat Keluar" text="{{ $totalSuratKeluar }}" icon="fas fa-file-export" text-white theme="success" progress="" />
        </div>
    </div>
    <div class="tabel" style="background-color: white; padding: 1.5rem; border-radius: 10px;">
        {{-- Setup data for datatables --}}
        @php
        $heads = [
        'Tanggal Surat',
        'Tanggal Diterima',
        'No. Surat',
        'Pengirim/Penerima',
        'Status',
        'Jenis Surat',
        'File',
        ];

        $config = [
        'dom' => 'ftp', // Hanya menampilkan tabel tanpa search, pagination, atau lengthMenu
        'pageLength' => 5, // Tetap tampilkan 5 data per halaman
        'paging' => true, // Pagination tetap aktif
        'ordering' => true,
        'columns' => [
        ['orderable' => false],
        ['orderable' => false],
        ['orderable' => false],
        ['orderable' => false],
        ['orderable' => false],
        ['orderable' => true],
        ['orderable' => false], // Kolom action tidak diurutkan
        ],
        ];
        @endphp


        {{-- Minimal example / fill data using the component slot --}}

        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
            @foreach($surat as $data)
            <tr>
                <td>{{ $data['tanggal_surat'] }}</td>
                <td>{{ $data['tanggal_diterima'] ?? '-' }}</td>
                <td>{{ $data['no_surat'] ?? '-' }}</td>
                <td>{{ $data['pengirim_tujuan'] }}</td>
                <td>{{ $data['status'] ?? '-' }}</td>
                <td>{{ $data['jenis'] }}</td>
                <td>
                    @if($data['file_surat'])
                    <a href="{{ route('surat.file', ['jenis' => $data['jenis'], 'id' => $data['id']]) }}" target="_blank">Lihat</a>
                    @else
                    -
                    @endif
                </td>
            </tr>

            @endforeach
        </x-adminlte-datatable>


    </div>
</div>
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<style type="text/css">
    p {
        margin-bottom: 0;
    }

    tr {
        align-items: center;
    }

    td {
        align-content: center;
        align-self: center;
    }

    .action {
        display: flex;
        align-content: center;
        justify-content: center;

    }

    th.sorting_desc {
        width: 30px;
    }
</style>

@endpush

{{-- Push extra scripts --}}

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                const url = this.dataset.url;
                window.location.href = url;
            });
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.checklist-status')) { // Jika tombol dengan class 'checklist-status' diklik
            e.preventDefault(); // Mencegah aksi default tombol

            const form = e.target.closest('.status-form'); // Cari form terdekat
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dichecklist dianggap sudah selesai!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, checklist!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form yang sesuai
                }
            });
        }
    });

    document.getElementById('delete-button').addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah aksi default tombol
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit(); // Kirim form jika dikonfirmasi
            }
        });
    });
</script>
@endpush