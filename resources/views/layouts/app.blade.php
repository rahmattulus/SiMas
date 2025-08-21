@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
{{ config('adminlte.title') }}
@hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
@hasSection('content_header_title')
<h1 class="text-muted">
    @yield('content_header_title')

    @hasSection('content_header_subtitle')
    <small class="text-dark">
        <i class="fas fa-xs fa-angle-right text-muted"></i>
        @yield('content_header_subtitle')
    </small>
    @endif
</h1>
@endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
@yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Add your common script logic here...
    });
</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<style type="text/css">
    .brand-link {
        text-decoration: none;
        color: black;
    }
</style>
@endpush