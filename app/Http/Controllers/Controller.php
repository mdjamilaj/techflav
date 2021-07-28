<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function sendResponse($result = [], $message ='', $code = 200)
    {
        $response = [
            'data'      => $result,
            'success'   => true,
            'message'   => $message,
        ];
        if (empty($result)) {
            unset($response['data']);
        }
        // return response()->json($response, 200);
        return new JsonResponse($response, $code);
    }

    public function sendCollectionResponse($collection, $message, $code = 200)
    {
        $response = [
            'data'      => $collection,
            'success'   => true,
            'message'   => $message,
        ];

        return new JsonResponse($response, $code);
    }

    public function sendError($error, $errorMessages = [], $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }
        if (empty($error)) {
            unset($response['message']);
        }

        return new JsonResponse($response, $code);
    }


    public function sendCustomError($error, $errorMessages = [], $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }
        if (empty($error)) {
            unset($response['message']);
        }
        return new JsonResponse($response, $code);
    }
}
