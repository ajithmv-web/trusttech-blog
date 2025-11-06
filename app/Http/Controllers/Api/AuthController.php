<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class AuthController extends Controller
{
    use ApiResponseTrait;

   public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' =>  'required',
                'password'  => 'required|string',
            ]);
            if ($validator->fails()) {
                return $this->returnValidation($validator->messages());
            }
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
            $credentials = [$fieldType =>request('email'), 'password' => request('password')];
            if (!$token =auth('api')->attempt($credentials)) {
                return $this->return400("email or username or password invalid");
            }
            return $this->respondWithToken($token);
        }catch (\Exception $e) {
           return $this->return400($e->getMessage());
        }
    }
    protected function respondWithToken($token)
    {
        try{    
        $user=auth('api')->user();
        return response()->json([
            'status' => true,
            'employee'=>auth('api')->user(),
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>auth('api')->factory()->getTTL() * 60,
        ]);
       }catch (\Exception $e) {
            return $this->return400($e->getMessage());
        }
    }
    protected function me(Request $request)
    {
        try{
        $user=User::find(auth('api')->user()->id);
         return $this->returnSucess($user);
       }catch (\Exception $e) {
         return $this->return400($e->getMessage());
        }
    }
}
