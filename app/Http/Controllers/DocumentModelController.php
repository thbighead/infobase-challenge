<?php

namespace App\Http\Controllers;

use App\DataTables\DocumentModelDataTable;
use App\DocumentModel;
use Illuminate\Http\Request;

class DocumentModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DocumentModelDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(DocumentModelDataTable $dataTable)
    {
        return $this->coreIndex($dataTable);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->coreCreate([
            'form_data' => $this->mountFormFields() + [
                    'action' => route('document_model.store'),
                    'back' => route('document_model.index')
                ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->coreStore($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->coreShow(DocumentModel::findOrFail($id), [
            'form_data' => $this->mountFormFields()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->coreEdit(DocumentModel::findOrFail($id), [
            'form_data' => $this->mountFormFields() + [
                    'action' => route('document_model.update', $id),
                    'back' => route('document_model.index')
                ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->coreUpdate($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->coreDestroy($id);
    }

    /**
     * Mount the fields layout and data to forms
     *
     * @return array
     */
    private function mountFormFields()
    {
        return ['fields' => [
            [
                'tag' => 'input',
                'label' => 'Nome',
                'name' => 'name',
                'type' => 'text',
                'grid' => 'col-sm-10'
            ],
            [
                'tag' => 'input',
                'label' => 'Versão',
                'name' => 'version',
                'type' => 'text',
                'grid' => 'col-sm-2',
//                'action' => 'this is just for always disabling'
            ],
            [
                'tag' => 'ckeditor',
                'label' => 'Cabeçalho',
                'name' => 'header',
                'grid' => 'col-xs-12'
            ],
            [
                'tag' => 'ckeditor',
                'label' => 'Rodapé',
                'name' => 'footer',
                'grid' => 'col-xs-12'
            ],
            [
                'tag' => 'checkbox',
                'label' => 'Finalizado',
                'name' => 'finished',
                'grid' => 'col-xs-12',
                'value' => true
            ],
        ]];
    }
}
