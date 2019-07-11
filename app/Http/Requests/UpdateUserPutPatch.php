<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use App\Rules\HashCheck;
use App\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Str;

class UpdateUserPutPatch extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('update', User::findOrFail($this->route('user')));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['sometimes', 'required', 'string', 'max:100'],
            'cpf' => ['sometimes', 'required', new Cpf],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:100', Rule::unique('users')
                ->ignore($this->route('user'))->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })],
            'phone' => ['sometimes', 'digits_between:8,20'],
            'profile' => ['sometimes', Rule::in(['USUARIO', 'ADMINISTRADOR'])],
        ];

        if (!Str::contains($this->url(), '/api/')) {
            $rules['password'] = 'required|confirmed';
            $rules['old_password'] = ['sometimes', new HashCheck(Auth::id())];
        }

        return $rules;
    }
}
