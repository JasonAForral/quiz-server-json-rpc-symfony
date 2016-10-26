<?php

namespace AppBundle\Tests\Repositories;

use AppBundle\Entity\ {Answer, Question};
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

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Beta');
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Gamma');
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Panda');
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($rightAnswer);

        $actual = count($possibleAnswers);

        $this->assertEquals($expected, $actual);
    }

    public function testGetPossibleAnswersAreAnswers()
    {
        $expected = [true, true, true, true];

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Beta');
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Gamma');
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Panda');
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($rightAnswer);

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

        $rightAnswer = new Answer();
        $rightAnswer->setText('Alpha');
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Beta');
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Gamma');
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Panda');
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($rightAnswer);

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

        $question = new Question();
        
        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Seven');
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Tomato');
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Up');
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($question);

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

        $rightAnswer = new Answer();
        $rightAnswer->setText('The greatest');
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Up');
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Dynamite');
        $this->entityManager->persist($wrongAnswer2);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($rightAnswer);

        $actual = count($possibleAnswers);

        $this->assertEquals($expected, $actual);
    }
}