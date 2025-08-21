@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', '')
@section('content_header_title', '')
@section('content_header_subtitle', '')

{{-- Content body: main page content --}}

@section('content_body')
<div class="tabel" style="background-color: white; padding: 1rem; border-radius: 10px;">
    {{-- Minimal example / fill data using the component slot --}}
    <h4>Form Disposisi Bidang Olahraga</h4>
    <hr>
    <form action="{{route('surat.store')}}" method="post" id="myForm">
        @csrf
        <div class="row">
            <div class="col">
                <div class="row mb-1 ">
                    <label for="inputEmail3" class="col-sm-3 form-label">Surat Dari</label>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-sm" id="inputEmail3" name="surat_dari" value="{{$surat->surat_dari}}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">No. Surat</label>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-sm" id="" placeholder=".../.../..." name="no_surat" value="{{$surat->no_surat}}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">Tgl Surat</label>
                    <div class="col-7">
                        <input type="date" class="form-control form-control-sm" id="inputEmail3" name="tanggal_surat" value="{{$surat->tanggal_surat}}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">Perihal</label>
                    <div class="col-7">
                        <textarea id="" class="form-control" name="perihal">{{$surat->perihal}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-1">
                    <label for="inputEmai" class="col-sm-3 form-label">Diterima</label>
                    <div class="col-7">
                        <input type="date" class="form-control form-control-sm" id="tanggal_diterima" name="tanggal_diterima" value="{{$surat->tanggal_diterima}}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">No. Agenda</label>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-sm" id="inputEmail3" name="no_agenda" value="{{$surat->no_agenda}}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="inputEmail3" class="col-sm-3 form-label">Sifat</label>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-sm" id="inputEmail3" name="sifat" value="{{$surat->sifat}}">
                    </div>
                </div>
                <div class="row mb-1">

                </div>
            </div>
        </div>
        <div class="row">
            <!-- Diteruskan Kpd --- Harap -->
            <div class="col">
                <label for="" class="form-label">Diteruskan Kepada Sdr :</label>
                <div class="form-check">
                    <input class="form-check-input"
                        type="checkbox"
                        name="ditujukan[0][value]"
                        value="SubKord. Olahraga Rekreasi & Masyarakat"
                        id="flexCheckDefault"
                        style="border: 1px solid #000;"
                        {{ in_array('SubKord. Olahraga Rekreasi & Masyarakat', $ditujukan ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">
                        SubKord. Olahraga Rekreasi & Masyarakat
                    </label>
                </div>



                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ditujukan[1][value]" value="Kepala UPTD Gor Satria" id="flexCheckDefault"
                        style="border: 1px solid #000;"
                        {{ in_array('Kepala UPTD Gor Satria', $ditujukan ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">
                        Kepala UPTD Gor Satria
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input"
                        type="checkbox"
                        name="ditujukan[2][value]"
                        value="Analis Keolahragaan"
                        id="flexCheckAnalis"
                        style="border: 1px solid #000;"
                        {{ collect($ditujukan ?? [])->contains(function ($value) {
                            return str_contains($value, 'Analis Keolahragaan');
                        }) ? 'checked' : '' }}>

                    <label class="form-check-label" for="flexCheckAnalis">
                        Analis Keolahragaan
                    </label>

                    <input type="text" name="ditujukan[2][tambahan]" id="opsilain" placeholder="Tambahkan keterangan"
                        value="{{ collect($ditujukan ?? [])->firstWhere(function ($value) {
                            return str_contains($value, 'Analis Keolahragaan');
                        }) ? substr(explode('(', collect($ditujukan ?? [])->firstWhere(function ($value) {
                            return str_contains($value, 'Analis Keolahragaan');
                        }))[1], 0, -1) : '' }}">
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
                </div>

            </div>
            <!-- Respon -->
            <div class="col">
                <label for="" class="form-label">Dengan hormat harap :</label>
                <div class="form-check">
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
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <label for="inputAddress" class="form-label">Catatan</label>
                <textarea id="" class="form-control" name="catatan">{{$surat->catatan}}</textarea>
            </div>
            <div class="col">
                <label for="inputEmail3" class="form-label">File Surat</label>
                <input type="file" class="col-7 form-control" id="inputGroupFile03" name="file_surat">
            </div>
        </div>
        <input type="hidden" name="status" value="proses">
        <hr>
        <!-- Footer -->
        <div class="row align-items-center mt-3 justify-content-end">
            <div class="col-auto ">
                <a href="{{ url('surat') }}">
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
</script>
@endpush