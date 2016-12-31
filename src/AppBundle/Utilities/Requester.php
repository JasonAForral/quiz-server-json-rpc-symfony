<?php

namespace AppBundle\Utilities;

class Requester
{
    static public function clientRequest($client, $request)
    {
        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );
    }
}
