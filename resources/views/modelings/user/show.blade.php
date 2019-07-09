@extends('layouts.form', $form_data)
@section('after-form')
    @if($is_logged_user)
        <!-- Button trigger modal -->
        <a href="{{ route('user.edit', Route::current()->parameter('user')) }}" type="button"
           class="btn btn-primary btn-lg">
            Trocar Senha
        </a>
    @endif
@endsection