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

        $actual = $questionRepository->getRandomQuestion(1) instanceof Question;

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

        $actual = $questionRepository->getRandomQuestion(1) instanceof Question;

        $this->assertEquals($expected, $actual);
    }

    public function testGetNewQuestionQuizId()
    {
        mt_srand(0);

        $expected = 'Test Quiz2';

        $question = new Question();
        $question->setText('test?');
        $this->entityManager->persist($question);

        $answer = new Answer();
        $answer->setText('tested!');
        $question->setAnswer($answer);
        $this->entityManager->persist($answer);

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $question2 = new Question();
        $question2->setText('test?2');
        $this->entityManager->persist($question2);

        $answer2 = new Answer();
        $answer2->setText('tested!2');
        $question2->setAnswer($answer2);
        $this->entityManager->persist($answer2);

        $quiz2 = new Quiz();
        $quiz2->setText('Test Quiz2');
        $question2->setQuiz($quiz2);
        $this->entityManager->persist($quiz2);

        $this->entityManager->flush();

        $questionRepository = $this->entityManager
            ->getRepository('AppBundle:Question')
        ;

        $actual = $questionRepository->getRandomQuestion(2)->getQuiz()->getText();

        $this->assertEquals($expected, $actual);
    }
}
