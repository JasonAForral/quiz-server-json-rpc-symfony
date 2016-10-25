<?php

namespace AppBundle\Tests\Repositories;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
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
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
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
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
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
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
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
        $expected = 3;

        $answerRepository = $this->entityManager
            ->getRepository('AppBundle:Answer')
        ;

        $rightAnswer = new Question();
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($rightAnswer);

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
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $this->entityManager->persist($wrongAnswer2);

        $this->entityManager->flush();
 
        $possibleAnswers = $answerRepository->getPossibleAnswers($rightAnswer);

        $actual = count($possibleAnswers);

        $this->assertEquals($expected, $actual);
    }
}