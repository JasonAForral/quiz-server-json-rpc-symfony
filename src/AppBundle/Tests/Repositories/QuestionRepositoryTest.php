<?php

namespace AppBundle\Tests\Transformers;

// use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Repositories\QuestionRepository;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use Liip\FunctionalTestBundle\Test\WebTestCase;
// use Doctrine\ORM\Tools\SchemaTool;

class QuestionRepositoryTest extends WebTestCase //KernelTestCase
{
    private $entityManager;

    // protected function setUp()
    // {
    //     self::bootKernel();
    //     $this->entityManager = static::$kernel->getContainer()
    //         ->get('doctrine')
    //         ->getManager()
    //     ;

    //     $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
    //     $tool = new SchemaTool($this->entityManager);
    //     $tool->createSchema($metadata);

    //  }

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
     * @expectedException TypeError
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