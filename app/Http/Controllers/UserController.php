<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\DataTables\UserDataTable;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(UserDataTable $dataTable)
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
                    'action' => route('user.store')
                ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $inputs = $request->all();
        $inputs['password'] = bcrypt($inputs['password']);
        return $this->coreStore($inputs);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->coreShow(User::findOrFail($id), [
            'form_data' => $this->mountFormFields(false),
            'is_logged_user' => Auth::id() == $id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $isLoggedUser = Auth::id() == $id;
        return $this->coreEdit(User::findOrFail($id), [
            'form_data' => $this->mountFormFields($isLoggedUser, $isLoggedUser) + [
                    'action' => route('user.update', $id),
                ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        return $this->coreUpdate($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->coreDestroy($id);
    }

    /**
     * Mount the fields layout and data to forms
     *
     * @param bool $withPasswordsFields
     * @param bool $withNewPassword
     * @return array
     */
    private function mountFormFields($withPasswordsFields = true, $withNewPassword = false)
    {
        $nonPasswordsFields = [
            -3 => [
                'tag' => 'input',
                'label' => 'Nome',
                'name' => 'name',
                'type' => 'text',
                'hint' => 'Nome Completo',
                'grid' => 'col-sm-6'
            ],
            -2 => [
                'tag' => 'input',
                'label' => 'E-mail',
                'name' => 'email',
                'type' => 'email',
                'hint' => 'name.lastname@dotlib.com.br',
                'grid' => 'col-sm-6'
            ]
        ];
        $passwordsFields = [
            [
                'tag' => 'input',
                'label' => 'Nova Senha',
                'name' => 'password',
                'type' => 'password',
                'grid' => 'col-sm-6'
            ],
            [
                'tag' => 'input',
                'label' => 'Confirmação de senha',
                'name' => 'password_confirmation',
                'type' => 'password',
                'grid' => 'col-sm-6'
            ]
        ];
        if ($withNewPassword) {
            $passwordsFields = [
                [
                    'tag' => 'input',
                    'label' => 'Senha Atual',
                    'name' => 'old_password',
                    'type' => 'password',
                    'grid' => 'col-sm-4'
                ],
                [
                    'tag' => 'input',
                    'label' => 'Nova Senha',
                    'name' => 'password',
                    'type' => 'password',
                    'grid' => 'col-sm-4'
                ],
                [
                    'tag' => 'input',
                    'label' => 'Confirmação de senha',
                    'name' => 'password_confirmation',
                    'type' => 'password',
                    'grid' => 'col-sm-4'
                ]
            ];
        }
        if ($withPasswordsFields)
            return ['fields' => $nonPasswordsFields + $passwordsFields];
        else
            return ['fields' => $nonPasswordsFields];
    }
}
