<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NifRule implements Rule
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
        $nif = trim($value);
        $nif_split = str_split($nif);
        $possible_first_digits = array(1, 2, 3, 5, 6, 7, 8, 9);

        if(is_numeric($nif) && strlen($nif) == 9 && in_array($nif_split[0], $possible_first_digits))
        {
            $check_digit = 0;
            for ($i = 0; $i < 8; $i++) {
                $check_digit += $nif_split[$i] * (10 - $i - 1);
            }
            $check_digit = 11 - ($check_digit % 11);
            $check_digit = $check_digit >= 10 ? 0 : $check_digit;
            if ($check_digit == $nif_split[8]) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O :attribute introduzido é invalido';
    }
}
