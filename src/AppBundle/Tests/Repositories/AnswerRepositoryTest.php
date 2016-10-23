<?php

namespace AppBundle\Tests\Repositories;

use AppBundle\Entity\Answer;
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

    public function testGetWrongAnswers()
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

        $wrongAnswer3 = new Answer();
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();
 
        $wrongAnswers = $answerRepository->getWrongAnswers($rightAnswer);

        $actual = count($wrongAnswers);

        $this->assertEquals($expected, $actual);
    }

    public function testGetWrongAnswersAreAnswers()
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
 
        $wrongAnswers = $answerRepository->getWrongAnswers($rightAnswer);

        $actual = ($wrongAnswers[0] instanceof Answer && $wrongAnswers[1] instanceof Answer && $wrongAnswers[2] instanceof Answer);

        $this->assertEquals($expected, $actual);
    }

    public function testGetWrongAnswersAreDifferentAnswers()
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
 
        $wrongAnswers = $answerRepository->getWrongAnswers($rightAnswer);

        $actual = (
            $rightAnswer->getId() !== $wrongAnswers[0]->getId() &&
            $rightAnswer->getId() !== $wrongAnswers[1]->getId() &&
            $rightAnswer->getId() !== $wrongAnswers[2]->getId() &&
            $wrongAnswers[0]->getId() !== $wrongAnswers[1]->getId() &&
            $wrongAnswers[0]->getId() !== $wrongAnswers[2]->getId() &&
            $wrongAnswers[1]->getId() !== $wrongAnswers[2]->getId()
        );

        $this->assertEquals($expected, $actual);
    }
}