<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * return error response.
     *
     * @param $all
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($all, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $all,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessage
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($error, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessage)){
            $response['data'] = $errorMessage;
        }

        return response()->json($response, $code);
    }
}
