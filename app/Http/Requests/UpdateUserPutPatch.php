<?php

namespace App\Http\Requests;

use App\Rules\HashCheck;
use App\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPutPatch extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('update', User::findOrFail($this->get('id')));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['sometimes', new HashCheck(Auth::id())],
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
