@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', '')
@section('content_header_title', '')
@section('content_header_subtitle', '')

@section('content_body')
<div class="title">
    <h1>BIDANG OLAHRAGA DINPORABUDPAR BANYUMAS</h1>
    <h4>Sistem Managemen Surat Masuk & Keluar </h4>
</div>

<div class="boxs">
    <x-adminlte-info-box title="Surat Masuk" text="" icon="fas fa-lg fa-envelope" theme="info"
        style="width: 25vw;" />
    <x-adminlte-info-box title="Telah ditindaklanjuti" text="" icon="fas fa-lg fa-check-square "
        theme="primary"  progress-theme="light" description="" style="width: 25vw;" />
</div>
@endsection

@push('css')
<style type="text/css">
    
    .title {
        background-color: blue;
        color: white;
        padding: 2rem;
        margin-top: 5rem;
        border-radius: 1rem;
    }
    .boxs{
        margin-top: 2rem;
    }
</style>
@endpush

@push('js')
@endpush