<?php

namespace AppBundle\Tests\Repositories;

// use AppBundle\Entity\ {Answer, Question};
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
    public function testGetQuizzes()
    {
        $expected = [];

        $quizRepository = $this->entityManager
            ->getRepository('AppBundle:Quiz')
        ;

        $actual = $quizRepository->getQuizzes();

        $this->assertEquals($expected, $actual);
    }
}