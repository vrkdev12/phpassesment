<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MacAddress implements Rule
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
        $index = explode('.', $attribute)[0];
        return filter_var(request()->mac_address[$index], FILTER_VALIDATE_MAC);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {  
        return 'The mac_address is invalid';
    }
}
