<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValorTelefone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return is_numeric($value) && strlen($value) == 9;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O telefone precisa conter apenas números e ter 9 caracteres (não incluindo caracteres especiais)';
    }
}
