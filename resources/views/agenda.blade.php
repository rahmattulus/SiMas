@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', '')
@section('content_header_title', '')
@section('content_header_subtitle', '')

{{-- Content body: main page content --}}

@section('content_body')
<div class="tabel" style="background-color: white; padding: 1rem; border-radius: 10px;">
    {{-- Minimal example / fill data using the component slot --}}
    <h4>Rekap Agenda</h4>
    <hr>
    <form action="{{ route('export.surat') }}" method="GET">
        <div class="row">
            <div class="col-md-3">
                <label for="jenis_surat">Jenis Surat</label>
                <select name="jenis_surat" class="form-control">
                    <option value="">Semua</option>
                    <option value="masuk" {{ request('jenis_surat') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                    <option value="keluar" {{ request('jenis_surat') == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
                </select>

            </div>

            <div class="col-md-3">
                <label for="bulan">Bulan</label>
                <select name="bulan" class="form-control">
                    <option value="">Semua</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                        @endfor
                </select>
            </div>

            <div class="col-md-3">
                <label for="tahun">Tahun</label>
                <select name="tahun" class="form-control">
                    <option value="">Semua</option>
                    @for ($i = now()->year; $i >= now()->year - 1; $i--)
                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-success">Export</button>
            </div>
        </div>
    </form>


</div>
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style type="text/css">
    body {
        height: 100vh;
    }

    #opsilain {
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        height: 24px;
    }

    .form-check-input {
        cursor: pointer;
    }
</style>

@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
    document.querySelectorAll('#myForm input, #myForm textarea').forEach((input, index, inputs) => {
        input.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Mencegah form submit saat Enter
                const nextInput = inputs[index + 1]; // Ambil input berikutnya
                if (nextInput) {
                    nextInput.focus(); // Pindahkan fokus ke input berikutnya
                }
            }
        });
    });

    // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
    function setTodayDate() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        const dd = String(today.getDate()).padStart(2, '0');
        const formattedDate = `${yyyy}-${mm}-${dd}`;

        // Tetapkan nilai default pada input
        document.getElementById('tanggal_diterima').value = formattedDate;
    }

    // Panggil fungsi setelah halaman dimuat
    window.onload = setTodayDate;
</script>
@endpush