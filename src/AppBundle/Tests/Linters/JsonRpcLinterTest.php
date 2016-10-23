<?php

namespace AppBundle\Tests\Linters;

use AppBundle\Linters\JsonRpcLinter;
use AppBundle\Results\JsonRpcLintResult;

class JsonRpcLinterTest extends \PHPUnit_Framework_TestCase
{

    public function testGetResultReturnsJsonRpcLintResult()
    {
        $expected = true;

        $json = [
            'jsonrpc' => '2.0',
            'method' => 'getQuestion',
            'id' => '1',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult instanceof JsonRpcLintResult;

        $this->assertEquals($expected, $actual);
        
    } 

    public function testGetResultChecksJsonRpcVersion()
    {
        $expected = true;

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'getQuestion',
            'id' => '1',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($request);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
        
    }

    public function testGetResultChecksJsonRpcVersionNotValid()
    {
        $expected = false;

        $json = [
            'jsonrpc' => '1.0',
            'method' => 'getQuestion',
            'id' => '1',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testGetResultChecksJsonRpcNoVersion()
    {
        $expected = false;

        $json = [
            'method' => 'getQuestion',
            'id' => '1',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testGetResultChecksJsonRpcNoId()
    {
        $expected = false;

        $json = [
            'jsonrpc' => '2.0',
            'method' => 'getQuestion',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testGetResultChecksJsonRpcNoMethodResultOrError()
    {
        $expected = false;

        $json = [
            'jsonrpc' => '2.0',
            'id' => '1',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testGetResultChecksJsonRpcResultValid()
    {
        $expected = true;

        $json = [
            'jsonrpc' => '2.0',
            'result' => 'something',
            'id' => '1',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }
}

