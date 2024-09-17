<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DifferentFromOldPassword implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       //
    }
    // public function validate(string $attribute, mixed $value, Closure $fail)
    // {
    //     public $currentPassword;

    //     public function __construct()
    //    {
    //        $this->currentPassword = Auth::user()->password;
    //    }
   
    //    public function passes($attribute, $value)
    //    {
    //        return !Hash::check($value, $this->currentPassword);
    //    }
   
    //    public function message()
    //    {
    //        return 'The new password must be different from the current password.';
    //    }
    // }
        
}


