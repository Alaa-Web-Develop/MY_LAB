<?php

namespace App\Http\Helpers;

trait ApiTrait {
    public function SuccessMessage(string $message = "",int $code = 200)
    {
        return response()->json(
            [
                'message'=>$message,
                // 'errors'=>(object)[],
                'data'=>(object)[],
            ],
            $code
        );
    }

    public function ErrorMessage(Array $errors , string $message = "",int $code = 422)
    {
        return response()->json(
            [
                'message'=>$message,
                'errors'=> $errors,
                // 'data'=>(object)[],
            ],
            $code
        );
    }

    public function Data(Array $data,string $message = "",int $code = 200)
    {
        return response()->json(
            [
                'message'=>$message,
                // 'errors'=>(object)[],
                'data'=>$data,
            ],
            $code
        );
    }

    //function to return error in try catch errors
    public function errorResonse($message,$code=400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code'=>$code
        ],$code);
    }
}