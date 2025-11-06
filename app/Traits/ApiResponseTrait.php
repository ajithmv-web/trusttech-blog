<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function returnSucess($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

        public function return400($message = 'Bad Request', $data = null)
        {
            return response()->json([
                'success' => false,
                'message' => $message,
                'data' => $data
            ], 400);
        }

    public static function returnValidation($errors=false){
        return response([
            'status'    => false,
            'error'     => $errors ? (is_array($errors) || is_object($errors)) ? $errors : ['common' => $errors] :  ['common' => config('app.internal_error')]
        ], 400);
    }
}