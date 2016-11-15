<?php

namespace AppBundle\Tests\Annotations;

use AppBundle\Entity\ {Answer, Question, Quiz};
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
        $question->setText('What is my id?');
        $this->entityManager->persist($question);

        $answer = new Answer();
        $answer->setText('One, I think.');
        $question->setAnswer($answer);
        $this->entityManager->persist($answer);

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

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

    /**
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function testQuestionHasNoText()
    {
        $expected = null;
        
        $question = new Question();
        $this->entityManager->persist($question);

        $answer = new Answer();
        $question->setAnswer($answer);
        $this->entityManager->persist($answer);
     
        $this->entityManager->flush();

        $actual = $question->getText();

        $this->assertEquals($expected, $actual);
    }
}