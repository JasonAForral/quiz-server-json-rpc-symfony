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

    public function testGetResultChecksJsonRpcResultValid1()
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

    public function testGetResultChecksIdValid1()
    {
        $expected = false;

        $json = [
            'jsonrpc' => '2.0',
            'result' => 'something',
            'id' => null,
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testGetResultChecksIdValid2()
    {
        $expected = false;

        $json = [
            'jsonrpc' => '2.0',
            'result' => 'something',
            'id' => 2.0,
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testGetResultChecksIdValid3()
    {
        $expected = true;

        $json = [
            'jsonrpc' => '2.0',
            'result' => 'something',
            'id' => 'camel',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testGetResultChecksIdValid4()
    {
        $expected = true;

        $json = [
            'jsonrpc' => '2.0',
            'result' => 'something',
            'id' => '-16',
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testGetResultChecksIdValid5()
    {
        $expected = false;

        $json = [
            'jsonrpc' => '2.0',
            'result' => 'something',
            'id' => true,
        ];

        $jsonRpcLintResult = JsonRpcLinter::getResult($json);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }
}
