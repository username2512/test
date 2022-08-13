<?php


Namespace App\Http\Controllers\API;
Use Illuminate\Http\Request;
Use App\Http\Controllers\Controller as Controller;


Class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    Public function sendResponse($result, $message)
    {
     $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        Return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    Public function sendError($error, $errorMessages = [], $code = 404)
    {
     $response = [
            'success' => false,
            'message' => $error,
        ];

        If(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        Return response()->json($response, $code);
    }
}
