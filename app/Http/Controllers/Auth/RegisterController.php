<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Auth\Users;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try{
            $success = false;
            $result = [];
            $responseCode = 200;

            $validator = Validator::make($request->all(), [
                'username'      => 'required',
                'email'     => 'required|email|unique:users',
                'password'  => 'required|min:8'
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            $user = Users::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            
            if($user) {
                $result = $user;
                $responseCode = 201;
            }

        }catch(\Exception $e){
            $result = $e->getMessage();
            $success = false;
            $responseCode = 409;
        }

        return response()->json([
            'success' => $success,
            'result' => $result
        ],$responseCode);
    }
}
