<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $result = [];
        $success = false;
        try{
            $validator = Validator::make($request->all(), [
                'username'     => 'required',
                'password'  => 'required'
            ]);
    
            //if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $credential = $request->only('username','password');
            $token = auth()->guard('api')->attempt($credential);

            if(!$token){
                throw new \Exception('Username Atau Password Salah');
            }

            $result = [
                'users' => auth()->guard('api')->user(),
                'token' => $token
            ];
            $success = true;
            
        }catch(\Exception $e){
            $result = $e->getMessage();
            $success = false;
        }
        return response()->json([
            'success' => $success,
            'result' => $result
        ],200);
    }

    public function username(){
        return 'username';
    }
}
