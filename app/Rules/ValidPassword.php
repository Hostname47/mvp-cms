<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPassword implements Rule
{
    public $lengthPasses = true;
    public $uppercasePasses = true;
    public $lowercasePasses = true;
    public $numericPasses = true;

    public $rules = ['length']; // Determines which rules to be applied into verifying password

    public function passes($attribute, $value)
    {
        $this->length_passes = strlen(trim($value)) >= 8;
        // $this->uppercasePasses = ((bool) preg_match('/[A-Z]/', $value));
        // $this->lowercasePasses = ((bool) preg_match('/[a-z]/', $value));
        // $this->numericPasses = ((bool) preg_match('/[0-9]/', $value));

        // return ($this->length_passes && $this->uppercasePasses && $this->lowercasePasses && $this->numericPasses);
        return $this->length_passes;
    }

    public function message()
    {
        // switch (true) {
        //     case !$this->uppercasePasses:
        //         return __('The password must contains at least one uppercase character');
        //     case !$this->lowercasePasses:
        //         return __('The password must contains at least one lowercase character');
        //     case !$this->numericPasses:
        //         return __('The password must contains at least one digit');
        //     default:
        //         return __('The password must contain at least 8 characters');
        // }
        return __('The password must contain at least 8 characters');
    }
}
