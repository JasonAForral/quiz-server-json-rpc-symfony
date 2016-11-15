<?php

namespace AppBundle\Tests\Utilities;

use AppBundle\Utilities\Responder;

class ResponderTest extends \PHPUnit_Framework_TestCase
{
    public function testErrorResponse()
    {
        $expected = [
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => 1,
                    'message' => 'No Questions Exception'
                ],
                'id' => 7,
            ];

        $actual = Responder::errorResponse(7, 1, 'No Questions Exception');

        $this->assertEquals($expected, $actual);
    }

    public function testErrorResponseData()
    {
        $expected = [
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => -32602,
                    'message' => 'Invalid params',
                    'data' => 'Missing params',
                ],
                'id' => 7,
            ];

        $actual = Responder::errorResponseData(
            7,
            -32602,
            'Invalid params',
            'Missing params'
        );

        $this->assertEquals($expected, $actual);
    }
}