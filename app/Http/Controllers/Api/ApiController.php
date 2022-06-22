<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function sendResponse($result, $message, $code = 200){
        $response = [
            "success" => true,
            // "data" => $result,
            "message" => $message,
            // "errorMessages" => $errorMessages
        ];

        // return response()->json([ $response, $code ]);
        return response()->json($response);
    }

    public function sendError($error, $errorMessages = [], $code = 404){
        $response = [
            "success" => false,
            // "data" => [],
            "message" => $error,
            // "errorMessages" => $errorMessages
        ];

        // return response()->json([ $response, $code ]);
        return response()->json($response);
    }
}
