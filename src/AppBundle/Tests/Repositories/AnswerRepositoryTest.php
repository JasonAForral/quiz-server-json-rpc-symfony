<?php

namespace AppBundle\Tests\Repositories;

use AppBundle\Entity\ {Answer, Question, Quiz};
use Liip\FunctionalTestBundle\Test\WebTestCase;

class AnswerRepositoryTest extends WebTestCase
{
    protected $entityManager;

    protected function setUp()
    {
        parent::setUp();
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $this->loadFixtures([]);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testGetPossibleAnswers()
    {
        $expected = 4;

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $this->entityManager->persist($quiz);

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $question = new Question();
        $question->setText('What is the first Greek letter?');
        $question->setAnswer($rightAnswer);
        $question->setQuiz($quiz);
        $this->entityManager->persist($question);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Beta');
        $this->entityManager->persist($wrongAnswer1);

        $question1 = new Question();
        $question1->setText('What is the first Greek letter?');
        $question1->setAnswer($wrongAnswer1);
        $question1->setQuiz($quiz);
        $this->entityManager->persist($question1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Gamma');
        $this->entityManager->persist($wrongAnswer2);

        $question2 = new Question();
        $question2->setText('What is the first Greek letter?');
        $question2->setAnswer($wrongAnswer2);
        $question2->setQuiz($quiz);
        $this->entityManager->persist($question2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Panda');
        $this->entityManager->persist($wrongAnswer3);

        $question3 = new Question();
        $question3->setText('What is the first Greek letter?');
        $question3->setAnswer($wrongAnswer3);
        $question3->setQuiz($quiz);
        $this->entityManager->persist($question3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($question);

        $actual = count($possibleAnswers);

        $this->assertEquals($expected, $actual);
    }

    public function testGetPossibleAnswersAreAnswers()
    {
        $expected = [true, true, true, true];

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $this->entityManager->persist($quiz);

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $question = new Question();
        $question->setText('What is the first Greek letter?');
        $question->setAnswer($rightAnswer);
        $question->setQuiz($quiz);
        $this->entityManager->persist($question);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Beta');
        $this->entityManager->persist($wrongAnswer1);

        $question1 = new Question();
        $question1->setText('What is the first Greek letter?');
        $question1->setAnswer($wrongAnswer1);
        $question1->setQuiz($quiz);
        $this->entityManager->persist($question1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Gamma');
        $this->entityManager->persist($wrongAnswer2);

        $question2 = new Question();
        $question2->setText('What is the first Greek letter?');
        $question2->setAnswer($wrongAnswer2);
        $question2->setQuiz($quiz);
        $this->entityManager->persist($question2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Panda');
        $this->entityManager->persist($wrongAnswer3);

        $question3 = new Question();
        $question3->setText('What is the first Greek letter?');
        $question3->setAnswer($wrongAnswer3);
        $question3->setQuiz($quiz);
        $this->entityManager->persist($question3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($question);

        $actual = array_map(function ($answer) {
            return $answer instanceof Answer;
        }, $possibleAnswers);

        $this->assertEquals($expected, $actual);
    }

    public function testGetPossibleAnswersAreDifferentAnswers()
    {
        $expected = true;

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $this->entityManager->persist($quiz);

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $question = new Question();
        $question->setText('What is the first Greek letter?');
        $question->setAnswer($rightAnswer);
        $question->setQuiz($quiz);
        $this->entityManager->persist($question);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Beta');
        $this->entityManager->persist($wrongAnswer1);

        $question1 = new Question();
        $question1->setText('What is the first Greek letter?');
        $question1->setAnswer($wrongAnswer1);
        $question1->setQuiz($quiz);
        $this->entityManager->persist($question1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Gamma');
        $this->entityManager->persist($wrongAnswer2);

        $question2 = new Question();
        $question2->setText('What is the first Greek letter?');
        $question2->setAnswer($wrongAnswer2);
        $question2->setQuiz($quiz);
        $this->entityManager->persist($question2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Panda');
        $this->entityManager->persist($wrongAnswer3);

        $question3 = new Question();
        $question3->setText('What is the first Greek letter?');
        $question3->setAnswer($wrongAnswer3);
        $question3->setQuiz($quiz);
        $this->entityManager->persist($question3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($question);

        $ids = array_map(function ($answer) {
            return $answer->getId();
        }, $possibleAnswers);

        $actual = $ids === array_unique($ids);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testGetPossibleAnswersTypeError()
    {
        $expected = 4;

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $this->entityManager->persist($quiz);

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $question = new Question();
        $question->setText('What is the first Greek letter?');
        $question->setAnswer($rightAnswer);
        $question->setQuiz($quiz);
        $this->entityManager->persist($question);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Seven');
        $this->entityManager->persist($wrongAnswer1);

        $question1 = new Question();
        $question1->setText('What is the first Greek letter?');
        $question1->setAnswer($wrongAnswer1);
        $question1->setQuiz($quiz);
        $this->entityManager->persist($question1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Gamma');
        $this->entityManager->persist($wrongAnswer2);

        $question2 = new Question();
        $question2->setText('What is the first Greek letter?');
        $question2->setAnswer($wrongAnswer2);
        $question2->setQuiz($quiz);
        $this->entityManager->persist($question2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Panda');
        $this->entityManager->persist($wrongAnswer3);

        $question3 = new Question();
        $question3->setText('What is the first Greek letter?');
        $question3->setAnswer($wrongAnswer3);
        $question3->setQuiz($quiz);
        $this->entityManager->persist($question3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($rightAnswer);

        $actual = count($possibleAnswers);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function testGetPossibleAnswersNotNullConstraintViolationException()
    {
        $expected = 4;

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $question = new Question();
        $this->entityManager->persist($question);

        $wrongAnswer1 = new Answer();
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($question);

        $actual = count($possibleAnswers);

        $this->assertEquals($expected, $actual);
    }


    /**
     * @expectedException AppBundle\Exceptions\TooFewAnswersException
     */
    public function testGetPossibleAnswersTooFewAnswers()
    {
        $expected = 3;

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $this->entityManager->persist($quiz);

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $question = new Question();
        $question->setText('What is the first Greek letter?');
        $question->setAnswer($rightAnswer);
        $question->setQuiz($quiz);
        $this->entityManager->persist($question);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Up');
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Dynamite');
        $this->entityManager->persist($wrongAnswer2);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($question);

        $actual = count($possibleAnswers);

        $this->assertEquals($expected, $actual);
    }

    public function testGetPossibleAnswersShuffles()
    {
        mt_srand(16);

        $expected = [1, 3, 2, 4];

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $this->entityManager->persist($quiz);

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $question = new Question();
        $question->setText('What is the first Greek letter?');
        $question->setAnswer($rightAnswer);
        $question->setQuiz($quiz);
        $this->entityManager->persist($question);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Beta');
        $this->entityManager->persist($wrongAnswer1);

        $question1 = new Question();
        $question1->setText('What is the first Greek letter?');
        $question1->setAnswer($wrongAnswer1);
        $question1->setQuiz($quiz);
        $this->entityManager->persist($question1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Gamma');
        $this->entityManager->persist($wrongAnswer2);

        $question2 = new Question();
        $question2->setText('What is the first Greek letter?');
        $question2->setAnswer($wrongAnswer2);
        $question2->setQuiz($quiz);
        $this->entityManager->persist($question2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Panda');
        $this->entityManager->persist($wrongAnswer3);

        $question3 = new Question();
        $question3->setText('What is the first Greek letter?');
        $question3->setAnswer($wrongAnswer3);
        $question3->setQuiz($quiz);
        $this->entityManager->persist($question3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($question);

        $actual = array_map(function ($answer) {
            return $answer->getId();
        }, $possibleAnswers);

        $this->assertEquals($expected, $actual);
    }

    public function testGetPossibleAnswersFromSpecificQuiz()
    {
        mt_srand(41);

        $expected = [
            3,
            1,
            5,
            4,
        ];

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $this->entityManager->persist($quiz);

        $answer1 = new Answer();
        $answer1->setText('Alpha');
        $this->entityManager->persist($answer1);

        $question = new Question();
        $question->setText('What is the first Greek letter?');
        $question->setAnswer($answer1);
        $question->setQuiz($quiz);
        $this->entityManager->persist($question);

        $quiz2 = new Quiz();
        $quiz2->setText('Test Quiz');
        $this->entityManager->persist($quiz2);

        $answer2 = new Answer();
        $answer2->setText('A');
        $this->entityManager->persist($answer2);

        $question2 = new Question();
        $question2->setText('What is the first letter of the alphabet?');
        $question2->setAnswer($answer2);
        $question2->setQuiz($quiz2);
        $this->entityManager->persist($question2);

        $answer3 = new Answer();
        $answer3->setText('Beta');
        $this->entityManager->persist($answer3);

        $question3 = new Question();
        $question3->setText('What is the second Greek letter?');
        $question3->setAnswer($answer3);
        $question3->setQuiz($quiz);
        $this->entityManager->persist($question3);

        $answer4 = new Answer();
        $answer4->setText('Gamma');
        $this->entityManager->persist($answer4);

        $question4 = new Question();
        $question4->setText('What is the third Greek letter?');
        $question4->setAnswer($answer4);
        $question4->setQuiz($quiz);
        $this->entityManager->persist($question4);

        $answer5 = new Answer();
        $answer5->setText('Panda');
        $this->entityManager->persist($answer5);

        $question5 = new Question();
        $question5->setText('Bear letter?');
        $question5->setAnswer($answer5);
        $question5->setQuiz($quiz);
        $this->entityManager->persist($question5);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($question);

        $actual = array_map(function ($answer) {
            return $answer->getId();
        }, $possibleAnswers);

        $this->assertEquals($expected, $actual);
    }
}