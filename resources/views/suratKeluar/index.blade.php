@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', '')
@section('content_header_title', 'Surat')
@section('content_header_subtitle', 'Keluar')

{{-- Content body: main page content --}}

@section('content_body')
<div class="card p-3">
    <div class="row">
        <h5 class="col"><b>Data Surat Keluar</b></h5>
        <a class="btn btn-sm btn-primary" href="suratKeluar/create">+ Tambah</a>
    </div>
    <div class="tabel" style="background-color: white; padding: 1.5rem; border-radius: 10px;">
        {{-- Setup data for datatables --}}
        @php
        $heads = [
        ['label' => 'No.', 'widht' => 1],
        ['label' => 'Surat', 'width' => 50],
        '',
        ];

        $config = [
        'dom' => 'ftp', // Hanya menampilkan tabel tanpa search, pagination, atau lengthMenu
        'pageLength' => 5, // Tetap tampilkan 5 data per halaman
        'paging' => true, // Pagination tetap aktif
        'order' => [[0, 'desc']],
        'ordering' => true,
        'columns' => [
        ['orderable' => true],
        ['orderable' => false],
        ['orderable' => false], // Kolom action tidak diurutkan
        ],
        ];
        @endphp


        {{-- Minimal example / fill data using the component slot --}}


        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
            @foreach($suratKl as $data)
            <tr>
                <td>
                    {{$data->agenda}}
                </td>
                <td data-url="{{ route('suratKeluar.show', $data->id) }}" class="clickable-row" style="cursor: pointer;">
                    <b>{{ $data->tujuan }}</b>
                    <p>{{$data->pengolah_surat}}</p>
                    <p>{{$data->tanggal_surat}}</p>
                </td>
                <td>
                    <div class="action">
                        <form class="delete-form" action="{{ route('suratKeluar.destroy', $data->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button id="delete-button" type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow delete-button" title="Delete">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </div>
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

    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function(e){
            e.preventDefault();
            let form = this.closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result)=> {
                if (result.isConfirmed){
                    form.submit();
                }
            })
        });
    });
</script>
@endpush