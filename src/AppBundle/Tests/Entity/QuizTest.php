<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Quiz;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;

class QuizTest extends \PHPUnit_Framework_TestCase
{
    public function testGetIdStartsAsNull()
    {
        $expected = null;

        $quiz = new Quiz();

        $actual = $quiz->getId();

        $this->assertEquals($expected, $actual);
    }

    public function testGetQuestionsStartsAsEmptyCollection()
    {
        $expected = true;

        $quiz = new Quiz();

        $actual = $quiz->getQuestions()->isEmpty();

        $this->assertEquals($expected, $actual);
    }

    public function testAddQuestionAndGetQuestion()
    {
        $expected = 2;

        $question1 = new Question();
        $question2 = new Question();

        $quiz = new Quiz();
        $quiz->addQuestion($question1);
        $quiz->addQuestion($question2);
        
        $actual = $quiz->getQuestions()->count();

        $this->assertEquals($expected, $actual);
    }

    public function testAddQuestionAndGetQuestionReturnsQuestions()
    {
        $expected = 'some text';

        $question = new Question();
        $question->setText('some text');

        $quiz = new Quiz();
        $quiz->addQuestion($question);
        
        $actual = $quiz->getQuestions()->first()->getText();

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

        $quiz = new Quiz();
        $quiz->addQuestion($question);
        
        $actual = $quiz->getQuestions()->first()->getText();

        $this->assertEquals($expected, $actual);
    }

    public function testAddQuestionAndRemoveQuestion()
    {
        $expected = 1;

        $question1 = new Question();
        $question2 = new Question();

        $quiz = new Quiz();
        $quiz->addQuestion($question1);
        $quiz->addQuestion($question2);
        
        $quiz->removeQuestion($question1);

        $actual = $quiz->getQuestions()->count();

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

        $quiz = new Quiz();
        $quiz->addQuestion($question1);
        $quiz->addQuestion($question2);
        
        $quiz->removeQuestion(new Answer());

        $actual = $quiz->getQuestions()->count();

        $this->assertEquals($expected, $actual);
    }
    
}