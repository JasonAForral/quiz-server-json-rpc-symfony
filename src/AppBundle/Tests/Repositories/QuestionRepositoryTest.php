<?php

namespace AppBundle\Tests\Transformers;

use AppBundle\Repositories\QuestionRepository;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class QuestionRepositoryTest extends WebTestCase
{
    private $entityManager;

    protected function setUp()
    {
        parent::setUp();
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $this->loadFixtures([]);

    }

    public function testGetNewQuestion()
    {
        $expected = true;

        $question = new Question();
        $question->setText('test?');

        $answer = new Answer();
        $answer->setText('tested!');
        $question->setAnswer($answer);
        
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