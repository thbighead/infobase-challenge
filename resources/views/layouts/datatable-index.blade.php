@extends('adminlte::page')

@section('content_header')
    <h1 class="page-header">{{ $title }}</h1>
@endsection

@section('content')
    @yield('before_table')
    <div class="table-responsive" style="overflow-x: scroll;">
        {!! $dataTable->table(['id' => 'laravel-datatable', 'class' => 'table table-hover', 'style' => 'width: 100%;'], true)  !!}
    </div>

    <script>
        function opendelswal(id) {
            swal({
                title: 'Tem certeza?',
                text: 'Após deletar este elemento não será mais exibido.',
                buttons: ['Cancelar', 'Ok'],
                dangerMode: true
            }).then(function (isConfirm) {
                if (!isConfirm) return;
                $.ajax({
                    url: "/{{ $model }}/" + id,
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    type: "DELETE",
                    dataType: 'json',
                    beforeSend: function () {
                        swal({
                            title: 'Aguarde!',
                            text: "Excluindo {{ $title }}...",
                            icon: 'info',
                            buttons: false,
                            allowOutsideClick: false
                        });
                    },
                    success: function (res) {
                        if (res.success == true) {
                            swal({
                                title: "Exclusão de {{ $title }}!",
                                text: 'Excluído com sucesso!',
                                icon: 'success',
                                buttons: [false, 'Ok']
                            }).then(function () {
                                window.location.reload();
                            });
                        } else {
                            swal({
                                title: 'Erro!',
                                text: 'Houve um erro e não foi possível excluir...',
                                icon: 'error',
                                buttons: [false, 'Ok']
                            });
                        }
                    },
                    error: function (res) {
                        console.log(res);
                    }
                })
            });
        }
    </script>
    @yield('after_table')
@endsection

@push('js')
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <script src="//cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush