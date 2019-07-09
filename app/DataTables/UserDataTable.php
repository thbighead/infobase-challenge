<?php

namespace App\DataTables;

use Arr;
use Auth;
use App\User;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($row) {
                return view('layouts.datatable-action-buttons', [
                    'model' => 'user',
                    'id' => $row->id,
                ]);
            });
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = User::query()->select($this->getColumns());

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = ['export', 'print'];
        Auth::user()->cant('create') ?: $buttons[] = 'create';
        return $this->builder()
            ->columns($this->getColumns(false))
            ->minifiedAjax('')
            ->addAction(['title' => 'Ações', 'width' => '150px', 'style' => 'min-width:110px;max-width:150px;'])
            ->parameters([
                'dom' => 'Blfrtip',
                'order' => [[0, 'desc']],
                'buttons' => $buttons,
                'language' => [
                    // Para mais informações visite https://datatables.net/plug-ins/i18n/Portuguese-Brasil
                    'url' => url('//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json')
                ],
                'initComplete' => file_get_contents(public_path('js/laravel-datatable-initcomplete.js')),
                'autoWidth' => true,
            ]);
    }

    /**
     * Get columns. If $forEloquent is set to false, this function returns the array as it is, which is used by the
     * datatable configuration. Otherwise, the array will be set to select the columns Eloquent should take.
     *
     * @param bool $forEloquent
     * @return array
     */
    protected function getColumns($forEloquent = true)
    {
        $columns = [
            ['data' => 'id', 'name' => 'id', 'title' => '#', 'footer' => 'ID'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Nome', 'footer' => 'Nome'],
            ['data' => 'email', 'name' => 'email', 'title' => 'E-mail', 'footer' => 'E-mail'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Data de Criação', 'footer' => 'Data de Criação'],
        ];

        if ($forEloquent)
            return Arr::pluck($columns, 'name');
        else
            return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
