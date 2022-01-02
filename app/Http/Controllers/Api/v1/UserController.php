<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\MainController as MainController;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends MainController
{
    public function index()
    {
        $data['orders'] = User::with(['orders'])->get();
        return $this->successResponse($data, 'Order list', Response::HTTP_OK);
    }

    public function register(UserRegistrationRequest $request)
    {
        $input = $request->only('name', 'email', 'password');
        $input['password'] = bcrypt($input['password']);
        $input['is_admin'] = false;
        $user = User::create($input);

        $data['accessToken'] =  $user->createToken('weDevsProject')->plainTextToken;
        $data['name'] =  $user->name;
        $data['email'] =  $user->email;

        if($user) {
            return $this->successResponse($data, 'User registered Successfully.',Response::HTTP_OK);
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

    public function logout()
    {
        $user = auth()->user()->currentAccessToken()->delete();
        if($user){
            return $this->successResponse('logout', 'User logout successfully.', Response::HTTP_OK);
        }else{
            return $this->errorResponse('logout.', ['error'=>'Logout Failed'], Response::HTTP_NOT_FOUND);
        }
    }

    public function show(User $user)
    {
        return $this->successResponse($user, 'View User', Response::HTTP_OK);
    }

    public function showOrders(User $user)
    {
        $data['orders'] = $user->orders()->with(['product'])->get();
        return $this->successResponse($data, 'Order list', Response::HTTP_OK);
    }

    protected function getFormattedData($user){
        $data['accessToken'] =  $user->createToken('weDevsProject')->plainTextToken;
        $data['name'] =  $user->name;
        $data['email'] =  $user->email;
        $data['is_admin'] =  $user->is_admin;
        $data['orders'] = Order::where('user_id',$user->id)->with('product')->get();
        $data['notification'][] = Auth::user()->notifications;
        return $data;
    }

    public function readNotification()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return $this->successResponse('Notification', 'Notification Mark as read successfully.',Response::HTTP_OK);
    }
}
