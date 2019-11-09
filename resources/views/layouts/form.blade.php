@extends('adminlte::page')

@section('content_header')
    <h1 class="page-header">{{ $title }}</h1>
    <a href="{{ route('home') }}" class="btn btn-default"><i
                class="fa fa-fw fa-arrow-circle-o-left"></i> Voltar</a>
@endsection

@section('content')
    @if(session('success') === true)
        <div id="form-alert" class="alert alert-success alert-dismissible"
             style="position: fixed; width: 25vw; z-index: 9999; top: 55px; right: 10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
            Objeto salvo com sucesso!
        </div>

        @push('js')
            <script src="{{ asset('js/form-success-alert.min.js') }}"></script>
        @endpush
    @elseif(session('success') === false)
        <div id="form-alert" class="alert alert-danger alert-dismissible"
             style="position: fixed; width: 25vw; z-index: 9999; top: 55px; right: 10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-close"></i> Erro!</h4>
            Ocorreu um erro e seu objeto não pôde ser salvo corretamente. Tente novamente.
        </div>

        @push('js')
            <script src="{{ asset('js/form-success-alert.min.js') }}"></script>
        @endpush
    @endif

    @yield('before-form')
    <form action="{{ isset($action) ? $action : '#' }}" method="POST">
        @isset($method_field)
            @method($method_field)
        @endisset
        @isset($action)
            @csrf
        @endisset
        @foreach($fields as $value)
            @php
                $colSizeSums = [
                    'xs' => 0,
                    'sm' => 0,
                    'md' => 0,
                    'lg' => 0,
                ];
                $sizes = array_keys($colSizeSums);
            @endphp
            @include("layouts.form-parts.{$value['tag']}", $value)
            @php
                $cols = explode(' ', $value['grid']);
                foreach ($cols as $col) {
                    $grid = explode('-', $col);
                    $gridSize = $grid[1];
                    $gridCols = last($grid);
                    $colSizeSums[$gridSize] += $gridCols;
                    if ($colSizeSums[$gridSize] >= 12) {
                        $pos = array_search($gridSize, $sizes);
                        $colSizeSums[$gridSize] = 0;
                        $clearfixHTML = '';
                        for ($i = $pos; $i < 4; $i++) {
                            $clearfixHTML .= " visible-{$sizes[$i]}-block";
                        }
                        if (!empty($clearfixHTML)) {
                            echo "<div class=\"clearfix$clearfixHTML\"></div>";
                        }
                    }
                }
            @endphp
        @endforeach
        @isset($action)
            <button type="submit" class="btn btn-primary pull-right">{{ isset($submit) ? $submit : 'OK' }}</button>
        @endisset
    </form>
    @yield('after-form')
@endsection
