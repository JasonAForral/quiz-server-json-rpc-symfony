<?php

namespace AppBundle\Utilities;

class Responder
{
    static public function errorResponse($id = null, $code, $message)
    {
        $response = [
            'id' => $id,
            'jsonrpc' => '2.0',
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ];
        return $response;
    }

    static public function errorResponseData($id = null, $code, $message, $data)
    {
        $response = [
            'id' => $id,
            'jsonrpc' => '2.0',
            'error' => [
                'code' => $code,
                'message' => $message,
                'data' => $data,
            ],
        ];
        return $response;
    }
}