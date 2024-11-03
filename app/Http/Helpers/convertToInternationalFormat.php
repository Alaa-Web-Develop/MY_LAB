<?php
namespace App\Http\Helpers;
class convertToInternationalFormat{
    public static function ConvertToInternationalFormat($phone){
        if(preg_match('/^01[0-2,5,9]{1}[0-9]{8}$/', $phone)){
            //preg_match Perform a regular expression match

            return '+2'.$phone;
        }
        return $phone;
    }
}