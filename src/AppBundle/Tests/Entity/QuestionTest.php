<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Question;

class QuestionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetIdStartsAsNull()
    {
        $expected = null;

        $question = new Question();

        $actual = $question->getId();

        $this->assertEquals($expected, $actual);
    }
}
