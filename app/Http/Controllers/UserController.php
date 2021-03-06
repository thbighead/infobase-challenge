<?php

namespace App\Http\Controllers;

use Str;
use Auth;
use App\Http\Requests\StoreUserPost;
use App\User;
use App\DataTables\UserDataTable;
use App\Http\Requests\UpdateUserPutPatch;

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
     * @param StoreUserPost $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserPost $request)
    {
        $inputs = $request->except('profile');
        $inputs['password'] = bcrypt($inputs['password']);
        $inputs['api_token'] = date('dmYHis') . Str::random(46);
        // $inputs['email_verified_at'] = now()->toDateTimeString();
        return $this->coreStore($inputs, [], [$request->get('profile') ? 'ADMINISTRADOR' : 'USUARIO']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $formData = $this->mountFormFields(false);
        $formData['fields'][-2] = [
            'tag' => 'input',
            'label' => 'API Token',
            'value' => $user->api_token,
            'name' => 'api_token',
            'type' => 'text',
            'grid' => 'col-xs-12'
        ];
        return $this->coreShow($user, [
            'form_data' => $formData,
            'is_logged_user' => Auth::id() == $id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param UpdateUserPutPatch $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPutPatch $request, $id)
    {
        return $this->coreUpdate($id, $request->all(), [], [$request->get('profile') ? 'ADMINISTRADOR' : 'USUARIO']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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
            -7 => [
                'tag' => 'checkbox',
                'label' => __('adminlte.admin'),
                'value' => 'ADMINISTRADOR',
                'name' => 'profile',
                'grid' => 'col-xs-12'
            ],
            -6 => [
                'tag' => 'input',
                'label' => Str::title(__('validation.attributes.name')),
                'name' => 'name',
                'type' => 'text',
                'hint' => __('adminlte.full_name'),
                'grid' => 'col-sm-6'
            ],
            -5 => [
                'tag' => 'input',
                'label' => __('adminlte.email'),
                'name' => 'email',
                'type' => 'email',
                'hint' => 'mail@mail.com',
                'grid' => 'col-sm-6'
            ],
            -4 => [
                'tag' => 'input',
                'label' => __('adminlte.cpf'),
                'name' => 'cpf',
                'type' => 'text',
                'hint' => __('adminlte.cpf_hint'),
                'grid' => 'col-sm-6'
            ],
            -3 => [
                'tag' => 'input',
                'label' => __('adminlte.phone'),
                'name' => 'phone',
                'type' => 'text',
                'hint' => __('adminlte.phone_hint'),
                'grid' => 'col-sm-6'
            ],
        ];
        $passwordsFields = [
            [
                'tag' => 'input',
                'label' => __('adminlte.new_password'),
                'name' => 'password',
                'type' => 'password',
                'grid' => 'col-sm-6'
            ],
            [
                'tag' => 'input',
                'label' => __('adminlte.password_confirmation'),
                'name' => 'password_confirmation',
                'type' => 'password',
                'grid' => 'col-sm-6'
            ]
        ];
        if ($withNewPassword) {
            $passwordsFields = [
                [
                    'tag' => 'input',
                    'label' => __('adminlte.old_password'),
                    'name' => 'old_password',
                    'type' => 'password',
                    'grid' => 'col-sm-4'
                ],
                [
                    'tag' => 'input',
                    'label' => __('adminlte.new_password'),
                    'name' => 'password',
                    'type' => 'password',
                    'grid' => 'col-sm-4'
                ],
                [
                    'tag' => 'input',
                    'label' => __('adminlte.password_confirmation'),
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
