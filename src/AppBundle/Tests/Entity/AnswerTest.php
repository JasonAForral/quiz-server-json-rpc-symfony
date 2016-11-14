<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\{Answer, Question};

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

    public function testGetQuestionsStartsAsEmptyCollection()
    {
        $expected = true;

        $answer = new Answer();

        $actual = $answer->getQuestions()->isEmpty();

        $this->assertEquals($expected, $actual);
    }

    public function testAddQuestionAndGetQuestion()
    {
        $expected = 2;

        $question1 = new Question();
        $question2 = new Question();

        $answer = new Answer();
        $answer->addQuestion($question1);
        $answer->addQuestion($question2);
        
        $actual = $answer->getQuestions()->count();

        $this->assertEquals($expected, $actual);
    }

    public function testAddQuestionAndGetQuestionReturnsQuestions()
    {
        $expected = 'some text';

        $question = new Question();
        $question->setText('some text');

        $answer = new Answer();
        $answer->addQuestion($question);
        
        $actual = $answer->getQuestions()->first()->getText();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testAddQuestionAndGetQuestionThrowsTypeError()
    {
        $expected = 'some text';

        $question = new Answer();
        $question->setText('some text');

        $answer = new Answer();
        $answer->addQuestion($question);
        
        $actual = $answer->getQuestions()->first()->getText();

        $this->assertEquals($expected, $actual);
    }

    public function testAddQuestionAndRemoveQuestion()
    {
        $expected = 1;

        $question1 = new Question();
        $question2 = new Question();

        $answer = new Answer();
        $answer->addQuestion($question1);
        $answer->addQuestion($question2);
        
        $answer->removeQuestion($question1);

        $actual = $answer->getQuestions()->count();

        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @expectedException TypeError
     */
    public function testAddQuestionAndRemoveQuestionThrowsTypeError()
    {
        $expected = 2;

        $question1 = new Question();
        $question2 = new Question();

        $answer = new Answer();
        $answer->addQuestion($question1);
        $answer->addQuestion($question2);
        
        $answer->removeQuestion(new Answer());

        $actual = $answer->getQuestions()->count();

        $this->assertEquals($expected, $actual);
    }

}
