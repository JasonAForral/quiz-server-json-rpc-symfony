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

    public function testSetTextAndGetText()
    {
        $expected = 'string';

        $question = new Question();
        $question->setText('string');

        $actual = $question->getText();

        $this->assertEquals($expected, $actual);
    }

    public function testSetTextAndGetText2()
    {
        $expected = 'string also';

        $question = new Question();
        $question->setText('string also');

        $actual = $question->getText();

        $this->assertEquals($expected, $actual);
    }
}
