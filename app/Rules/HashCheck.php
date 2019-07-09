<?php

namespace App\Rules;

use App\User;
use Hash;
use Illuminate\Contracts\Validation\Rule;

class HashCheck implements Rule
{
    private $user_id;

    /**
     * Create a new rule instance.
     *
     * @param $user_id
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, User::find($this->user_id)->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('auth.failed');
    }
}
