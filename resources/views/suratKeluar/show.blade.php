@extends('adminlte::page')

@section('title', '')

@section('content_header')
@stop

@section('content')
<div class="tabel" style="background-color: white; padding: 1rem; border-radius: 10px;">
    {{-- Minimal example / fill data using the component slot --}}
    <div class="row align-items-center">
        <div class="col">
            <h4>{{$suratKeluar->tujuan}}</h4>
        </div>
        <div class="col-auto ">
            <a href="{{ url('suratKeluar') }}" class="btn btn-danger btn-sm mt-2">
                <i class="fas fa-arrow-left fa-xs"></i>
            </a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">Tgl Surat</label>
                <div class="col-7">
                    <input type="date" class="form-control form-control-sm" id="inputEmail3" name="tanggal_surat" value="{{ $suratKeluar->tanggal_surat }}" disabled>
                </div>
            </div>
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">No. Surat</label>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" id="" name="no_surat" value="{{ $suratKeluar->no_surat }}" disabled>
                </div>
            </div>
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">Perihal</label>
                <div class="col-7">
                    <textarea id="" class="form-control" name="perihal" disabled>{{ $suratKeluar->perihal }}</textarea>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">No. Agenda</label>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" id="inputEmail3" name="agenda" value="{{$suratKeluar->agenda}}" disabled>
                </div>
            </div>
            <div class="row mb-1 ">
                <label for="inputEmail3" class="col-sm-3 form-label">Pengolah Surat</label>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" id="inputEmail3" name="pengolah_surat" value="{{ $suratKeluar->pengolah_surat }}" disabled>
                </div>
            </div>
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">Lain - lain</label>
                <div class="col-7">
                    <textarea id="" class="form-control" name="lain_lain" disabled>{{ $suratKeluar->lain_lain }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col"></div>
        <div class="col">
            <label for="inputEmail3" class="form-label">File Surat</label>
            @if($suratKeluar->file_surat)
            @php
            $fileExtension = pathinfo($suratKeluar->file_surat, PATHINFO_EXTENSION);
            @endphp

            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
            <img src="{{ route('surat_keluar.view', $suratKeluar->id) }}" alt="File Surat" width="300" height="300"
                style="object-fit: contain; max-width: 100%; height: auto;">
            @else
            <iframe src="{{ route('surat_keluar.view', $suratKeluar->id) }}" width="100%" height="70%"></iframe>
            @endif

            <br>
            <a href="{{ route('surat_keluar.view', $suratKeluar->id) }}" class="btn btn-primary mt-2 btn-sm" target="_blank">
                <i class="fas fa-external-link-alt fa-xs"></i>
            </a>
            @else
            <p>Tidak ada file surat tersedia.</p>
            @endif


        </div>
        <input type="hidden" name="status" value="proses">
    </div>
    <!-- Footer -->
    <div class="row align-items-center mt-3 justify-content-end">
    </div>
</div>
@stop

@push('css')
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

    .brand-link {
        text-decoration: none;
        color: black;
    }
</style>
@endpush

@push('js')
<script>

</script>
@endpush