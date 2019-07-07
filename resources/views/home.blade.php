@extends('adminlte::page')

@section('title', 'Infobase Challenge')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@inject('users', 'App\User')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{ __('adminlte.users') }}</span>
                        <span class="info-box-number">{{ $users->count() }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
    </section>
@stop