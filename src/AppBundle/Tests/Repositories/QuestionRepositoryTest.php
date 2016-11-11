<?php

namespace AppBundle\Tests\Transformers;

use AppBundle\Entity\ {Answer, Question, Quiz};
use AppBundle\Repositories\QuestionRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class QuestionRepositoryTest extends WebTestCase
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

    public function testGetNewQuestion()
    {
        $expected = true;

        $question = new Question();
        $question->setText('test?');

        $answer = new Answer();
        $answer->setText('tested!');
        $question->setAnswer($answer);

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $this->entityManager->persist($question);
        $this->entityManager->persist($answer);
        $this->entityManager->flush();

        $questionRepository = $this->entityManager
            ->getRepository('AppBundle:Question')
        ;

        $actual = $questionRepository->getRandomQuestion() instanceof Question;

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException AppBundle\Exceptions\NoQuestionsException
     */
    public function testGetNewQuestionWhenNoQuestions()
    {
        $expected = true;

        $questionRepository = $this->entityManager
            ->getRepository('AppBundle:Question')
        ;

        $actual = $questionRepository->getRandomQuestion() instanceof Question;

        $this->assertEquals($expected, $actual);
    }
}