<?php

namespace AppBundle\Tests\Annotations;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Repositories\QuestionRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class QuestionAnnotationTest extends WebTestCase
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

    public function testGetId() {
        $expected = 1;
        
        $question = new Question();
        $this->entityManager->persist($question);

        $answer = new Answer();
        $question->setAnswer($answer);
        $this->entityManager->persist($answer);

     
        $this->entityManager->flush();

        $actual = $question->getId();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function testQuestionHasNoAnswer()
    {
        $expected = true;
        
        $question = new Question();
        $this->entityManager->persist($question);
     
        $this->entityManager->flush();

        $actual = $question->getAnswer();

        $this->assertEquals($expected, $actual);
    }
}