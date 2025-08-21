@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', '')
@section('content_header_title', '')
@section('content_header_subtitle', '')

{{-- Content body: main page content --}}

@section('content_body')
<div class="tabel" style="background-color: white; padding: 1rem; border-radius: 10px;">
    {{-- Minimal example / fill data using the component slot --}}
    <h4>Agenda Surat Keluar</h4>
    <hr>
    <form action="{{route('suratKeluar.store')}}" method="post" id="myForm" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col">
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">Tgl Surat</label>
                    <div class="col-7">
                        <input type="date" class="form-control form-control-sm" id="inputEmail3" name="tanggal_surat">
                    </div>
                </div>
                <div class="row mb-1 ">
                    <label for="inputEmail3" class="col-sm-3 form-label">Dikirim Kepada</label>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-sm" id="inputEmail3" name="tujuan">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">No. Surat</label>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-sm" id="" placeholder=".../.../..." name="no_surat">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">Perihal</label>
                    <div class="col-7">
                        <textarea id="" class="form-control" name="perihal"></textarea>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">No. Agenda</label>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-sm" id="inputEmail3" name="agenda" value="{{$default_agenda ?? ''}}">
                    </div>
                </div>
                <div class="row mb-1 ">
                    <label for="inputEmail3" class="col-sm-3 form-label">Pengolah Surat</label>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-sm" id="inputEmail3" name="pengolah_surat">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">Lain - lain</label>
                    <div class="col-7">
                        <textarea id="" class="form-control" name="lain_lain"></textarea>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">File Surat</label>
                    <div class="col-7">
                        <input type="file" class="form-control form-control-sm" id="inputGroupFile03" name="file_surat">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <!-- Footer -->
        <div class="row align-items-center mt-3 justify-content-end">
            <div class="col-auto ">
                <a href="{{ url('suratKeluar') }}">
                    <x-adminlte-button label="Batal" theme="danger" icon="" />
                </a>
            </div>
            <div class="col-auto ">
                <button class="btn btn-primary" type="submit">Simpan</button>
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