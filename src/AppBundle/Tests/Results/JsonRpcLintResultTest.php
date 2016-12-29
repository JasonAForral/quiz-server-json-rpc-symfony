<?php

namespace AppBundle\Tests\Results;

use AppBundle\Results\JsonRpcLintResult;

class JsonRpcLintResultTest extends \PHPUnit_Framework_TestCase
{
    public function testSetValidAndGetValid()
    {
        $expected = true;

        $jsonRpcLintResult = new JsonRpcLintResult();

        $jsonRpcLintResult->setValid(true);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testSetValidAndGetValidReturnsFalse()
    {
        $expected = false;

        $jsonRpcLintResult = new JsonRpcLintResult();

        $jsonRpcLintResult->setValid(false);

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testSetValidTypeError()
    {
        $jsonRpcLintResult = new JsonRpcLintResult();

        $jsonRpcLintResult->setValid(null);
    }

    /**
     * @expectedException TypeError
     */
    public function testSetValidTypeError1()
    {
        $jsonRpcLintResult = new JsonRpcLintResult();

        $jsonRpcLintResult->setValid(1);
    }
}
