<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\MainController as MainController;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends MainController
{
    public function register(UserRegistrationRequest $request)
    {
        $input = $request->only('name', 'email', 'password');
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $userdata = $this->getFormattedData($user);
        if($user) {
            return $this->successResponse($userdata, 'User registered Successfully.',Response::HTTP_OK);
        }
        else {
            return $this->errorResponse('failed to register', ['error'=>'User Registration Failed.'], Response::HTTP_NOT_FOUND);
        }
    }

    public function login(UserLoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $userdata = $this->getFormattedData($user);
            return $this->successResponse($userdata, 'User login Successful.', Response::HTTP_OK);
        }
        elseif (!Auth::attempt()) {
            return $this->errorResponse('failed to login.','Credentials did not match', Response::HTTP_NOT_FOUND);
        }
        else{
            return $this->errorResponse('Unauthorised.', ['error'=>'Sorry you are Unauthorised!'], Response::HTTP_NOT_FOUND);
        }
    }

    protected function getFormattedData($user){
        $data['token'] =  $user->createToken('weDevsProject')->plainTextToken;
        $data['name'] =  $user->name;
        $data['email'] =  $user->email;
        return $data;
    }
}
