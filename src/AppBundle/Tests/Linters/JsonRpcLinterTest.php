<?php

namespace AppBundle\Tests\Linters;

use AppBundle\Linters\JsonRpcLinter;
use AppBundle\Results\JsonRpcLintResult;

class JsonRpcLinterTest extends \PHPUnit_Framework_TestCase
{

    public function testGetResultReturnsJsonRpcLintResult()
    {
        $expected = true;

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'getQuestion',
            'id' => '1',
        ];

        $lintResult = JsonRpcLinter::getResult($request);

        $actual = $lintResult instanceof JsonRpcLintResult;

        $this->assertEquals($expected, $actual);
        
    } 
}

