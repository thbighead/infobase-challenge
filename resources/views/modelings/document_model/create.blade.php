@extends('layouts.form', $form_data)

@section('before-form')
    <div id="doking_vue_app">
        @endsection
        @section('after-form')
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('full-page-loader').style.display = 'inline-block';
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
