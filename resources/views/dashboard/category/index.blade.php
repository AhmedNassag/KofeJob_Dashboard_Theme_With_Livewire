@extends('layouts.master')

@section('css')
    <!-- Print -->
    <style>
        @media print {
            .notPrint {
                display: none;
            }
        }
    </style>
    @section('title')
        {{ trans('main.Categories') }}
    @stop
@endsection



@section('content')

	<!-- Page Wrapper -->
    <div class="page-wrapper">

        <livewire:category-component>

    </div>
    <!-- /Page Wrapper -->
</div>
<!-- /Main Wrapper -->
@endsection



@section('js')
    <script>
        window.addEventListener('closeModal', event => {
            $('#addModal').modal('hide');
            $('#editModal').modal('hide');
            $('#deleteModal').modal('hide');
        })
    </script>
@endsection
