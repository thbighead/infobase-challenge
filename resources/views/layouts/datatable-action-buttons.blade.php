<div class="btn-group btn-group-justified" role="group" aria-label="Action buttons group">
    @can('view', App\User::findOrFail($id))
        <a href="{{ route("$model.show", $id) }}" class="btn btn-info" role="button" data-toggle="tooltip"
           title="Visualizar">
            <i class="fa fa-eye"></i>
        </a>
    @endcan
    @can('update', App\User::findOrFail($id))
        <a href="{{ route("$model.edit", $id) }}" class="btn btn-primary" role="button" data-toggle="tooltip"
           title="Editar">
            <i class="fa fa-edit"></i>
        </a>
    @endcan
    @can('delete', App\User::findOrFail($id))
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-danger" data-toggle="tooltip" title="Apagar"
                    onclick="opendelswal({{ $id }})">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    @endcan
</div>