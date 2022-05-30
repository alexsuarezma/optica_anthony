<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function sendResponse($result, $message, $code = 200){
        $response = [
            "success" => true,
            "data" => $result,
            "message" => $message
        ];

        return response()->json([ $response, $code ]);
    }

    public function sendError($error, $errorMessages = [], $code = 404){
        $response = [
            "success" => false,
            "error" => $error,
            "errorMessages" => $errorMessages
        ];

        return response()->json([ $response, $code ]);
    }
}
