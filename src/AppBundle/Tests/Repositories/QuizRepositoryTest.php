<?php

namespace AppBundle\Tests\Repositories;

use AppBundle\Entity\Quiz;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class QuizRepositoryTest extends WebTestCase
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

    /**
     * @expectedException AppBundle\Exceptions\NoQuizzesException
     */
    public function testGetQuizzesNoQuizzesException()
    {
        $expected = [];

        $quizRepository = $this->entityManager
            ->getRepository('AppBundle:Quiz')
        ;

        $actual = $quizRepository->getQuizzes();

        $this->assertEquals($expected, $actual);
    }

    public function testGetQuizzes()
    {
        $expected = 1;

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $this->entityManager->persist($quiz);

        $this->entityManager->flush();

        $quizRepository = $this->entityManager
            ->getRepository('AppBundle:Quiz')
        ;

        $actual = count($quizRepository->getQuizzes());

        $this->assertEquals($expected, $actual);
    }
}
