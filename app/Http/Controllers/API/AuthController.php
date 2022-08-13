<?php

namespace App\Http\Controllers\API;

Use Illuminate\Http\Request;
Use App\Http\Controllers\API\BaseController as BaseController;
Use Illuminate\Support\Facades\Auth;
Use Validator;
Use App\Models\User;


class AuthController extends BaseController
{
    

    Public function signin(Request $request)
    {
        If(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken; 
            $success['name'] =  $authUser->name;
   
            Return $this->sendResponse($success, 'User signed in');
        } 
        Else{ 
            Return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    Public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        If($validator->fails()){
            Return $this->sendError('Error validation', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        Return $this->sendResponse($success, 'User created successfully.');
    }
   
}


