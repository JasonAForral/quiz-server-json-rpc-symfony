<?php

namespace AppBundle\Tests\Utilities;

use AppBundle\Utilities\Requester;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class RequesterTest extends WebTestCase
{
    public function testApiReturns200()
    {
        $expected = 200;

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        Requester::clientRequest($client, $request);

        $actual = $client->getResponse()->getStatusCode();

        $this->assertEquals($expected, $actual);
    }
}
