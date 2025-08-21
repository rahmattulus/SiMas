@extends('adminlte::page')

@section('title', '')

@section('content_header')
@stop

@section('content')
<div class="tabel" style="background-color: white; padding: 1rem; border-radius: 10px;">
    {{-- Minimal example / fill data using the component slot --}}
    <div class="row align-items-center">
        <div class="col">
            <h4>{{$surat->surat_dari}}</h4>
        </div>
        <div class="col-auto ">
            <a href="{{ url('surat') }}" class="btn btn-danger btn-sm mt-2">
                <i class="fas fa-arrow-left fa-xs"></i>
            </a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">No. Surat</label>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" name="no_surat" value="{{$surat->no_surat}}" disabled>
                </div>
            </div>
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">Tgl Surat</label>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" id="inputEmail3" name="tanggal_surat" value="{{$surat->tanggal_surat}}" disabled>
                </div>
            </div>
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">Perihal</label>
                <div class="col-7">
                    <textarea id="" class="form-control" name="perihal" disabled>{{ $surat->perihal }}</textarea>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row mb-1">
                <label for="inputEmai" class="col-sm-3 form-label">Diterima</label>
                <div class="col-7">
                    <input type="date" class="form-control form-control-sm" id="tanggal_diterima" name="tanggal_diterima" value="{{$surat->tanggal_diterima}}" disabled>
                </div>
            </div>
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">No. Agenda</label>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" id="inputEmail3" name="no_agenda" value="{{$surat->no_agenda}}" disabled>
                </div>
            </div>
            <div class="row mb-1">
                <label for="inputEmail3" class="col-sm-3 form-label">Sifat</label>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" id="inputEmail3" name="sifat" value="{{ $surat->sifat }}" disabled>
                </div>
            </div>
        </div>
    </div>
    <!-- Diteruskan Kpd --- Harap -->
    @php
    $ditujukan = json_decode($surat->ditujukan, true) ?? [];
    $respon = json_decode($surat->respon, true) ?? [];
    @endphp
    <div class="row">
        <div class="col">
            <label for="" class="form-label">Diteruskan Kepada Sdr :</label>
            @foreach($ditujukan as $tujuan)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $tujuan }}" checked disabled>
                <label class="form-check-label">{{ $tujuan }}</label>
            </div>
            @endforeach
            <!-- <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ditujukan[0][value]" value="SubKord. Olahraga Rekreasi & Masyarakat" id="flexCheckDefault"
                    style="border: 1px solid #000;">
                <label class="form-check-label" for="flexCheckDefault">
                    SubKord. Olahraga Rekreasi & Masyarakat
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ditujukan[1][value]" value="Kepala UPTD Gor Satria" id="flexCheckDefault"
                    style="border: 1px solid #000;">
                <label class="form-check-label" for="flexCheckDefault">
                    Kepala UPTD Gor Satria
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ditujukan[2][value]" value="Analis Keolahragaan"
                    style="border: 1px solid #000;">
                <label class="form-check-label">
                    Analis Keolahragaan
                </label>
                <input type="text" name="ditujukan[2][tambahan]" id="opsilain" placeholder="">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ditujukan[3][value]" value="Agendaris"
                    style="border: 1px solid #000;">
                <label class="form-check-label">
                    Agendaris
                </label>
                <input type="text" name="ditujukan[3][tambahan]" id="opsilain" placeholder="">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ditujukan[4][value]" value="Lainnya"
                    style="border: 1px solid #000;">
                <input type="text" name="ditujukan[4][tambahan]" id="opsilain" placeholder="">
            </div> -->

        </div>
        <!-- Respon -->
        <div class="col">
            <label for="" class="form-label">Dengan hormat harap :</label>
            @foreach($respon as $r)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $r }}" checked disabled>
                <label class="form-check-label">{{ $r }}</label>
            </div>
            @endforeach
            <!-- <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Tanggapan dan Saran" id="flexCheckDefault" name="respon[0][harap]"
                    style="border: 1px solid #000;">
                <label class="form-check-label" for="flexCheckDefault">
                    Tanggapan dan Saran
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Proses Lebih Lanjut" id="flexCheckDefault" name="respon[1][harap]"
                    style="border: 1px solid #000;">
                <label class="form-check-label" for="flexCheckDefault">
                    Proses Lebih Lanjut
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Wakili/dampingi" id="flexCheckDefault" name="respon[2][harap]"
                    style="border: 1px solid #000;">
                <label class="form-check-label" for="flexCheckDefault">
                    Wakili/dampingi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Selesaikan sesuai ketentuan" id="flexCheckDefault" name="respon[3][harap]"
                    style="border: 1px solid #000;">
                <label class="form-check-label" for="flexCheckDefault">
                    Selesaikan sesuai ketentuan
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Untuk Informasi" id="flexCheckDefault" name="respon[4][harap]"
                    style="border: 1px solid #000;">
                <label class="form-check-label" for="flexCheckDefault">
                    Untuk Informasi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Arsipkan" id="flexCheckDefault" name="respon[5][harap]"
                    style="border: 1px solid #000;">
                <label class="form-check-label" for="flexCheckDefault">
                    Arsipkan
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Lainnya" id="flexCheckDefault" name="respon[6][harap]"
                    style="border: 1px solid #000;">
                <input type="text" name="respon[6][lainnya]" id="opsilain">
            </div> -->
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <label for="inputAddress" class="form-label">Catatan</label>
            <textarea id="" class="form-control" name="catatan" disabled>{{ $surat->catatan }}</textarea>
        </div>
        <div class="col">
            <label for="inputEmail3" class="form-label">File Surat</label>
            @if($surat->file_surat)
            @php
            $fileExtension = pathinfo($surat->file_surat, PATHINFO_EXTENSION);
            @endphp

            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
            <img src="{{ route('surat_masuk.view', $surat->id) }}" alt="File Surat" width="300" height="300"
                style="object-fit: contain; max-width: 100%; height: auto;">
            @else
            <iframe src="{{ route('surat_masuk.view', $surat->id) }}" width="100%" height="70%"></iframe>
            @endif

            <br>
            <a href="{{ route('surat_masuk.view', $surat->id) }}" class="btn btn-primary mt-2 btn-sm" target="_blank">
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