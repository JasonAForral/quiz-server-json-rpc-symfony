<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Answer;

class AnswerTest extends \PHPUnit_Framework_TestCase
{
  public function testGetIdStartsAsNull()
  {
    $expected = null;

    $answer = new Answer();

    $actual = $answer->getId();

    $this->assertEquals($expected, $actual);
  }

  public function testSetTextAndGetText()
  {
    $expected = 'string';

    $answer = new Answer();
    $answer->setText('string');

    $actual = $answer->getText();

    $this->assertEquals($expected, $actual);
  }

  public function testSetTextAndGetText2()
  {
    $expected = 'string also';

    $answer = new Answer();
    $answer->setText('string also');

    $actual = $answer->getText();

    $this->assertEquals($expected, $actual);
  }

  /**
    * @expectedException TypeError
    */
  public function testSetTextAndGetTextArray()
  {
    $expected = array();

    $answer = new Answer();
    $answer->setText(array());

    $actual = $answer->getText();

    $this->assertEquals($expected, $actual);
  }

  /**
    * @expectedException TypeError
    */
  public function testSetTextAndGetTextNumber()
  {
    $expected = 4;

    $answer = new Answer();
    $answer->setText(4);

    $actual = $answer->getText();

    $this->assertEquals($expected, $actual);
  }
}
