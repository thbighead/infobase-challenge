<?php

namespace App\Http\Requests;

use Str;
use Auth;
use App\User;
use App\Rules\Cpf;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'cpf' => ['required', new Cpf],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'phone' => ['digits_between:8,20'],
            'password' => ['required', 'string', 'min:6'],
            'profile' => ['sometimes', Rule::in(['USUARIO', 'ADMINISTRADOR'])],
        ];

        if (!Str::contains($this->url(), '/api/')) $rules['password'][] = 'confirmed';

        return $rules;
    }
}
