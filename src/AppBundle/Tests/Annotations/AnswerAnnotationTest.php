<?php

namespace AppBundle\Tests\Annotations;

use AppBundle\Entity\ {Answer};
use AppBundle\Repositories\QuestionRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class AnswerAnnotationTest extends WebTestCase
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

    public function testGetId()
    {

        $expected = 1;
        
        $answer = new Answer();
        $answer->setText('Yes!');
        $this->entityManager->persist($answer);

        $this->entityManager->flush();

        $actual = $answer->getId();

        $this->assertEquals($expected, $actual);
    }


    /**
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function testAnswerHasNoText()
    {
        $expected = null;
        
        $answer = new Answer();
        $this->entityManager->persist($answer);
     
        $this->entityManager->flush();

        $actual = $answer->getText();

        $this->assertEquals($expected, $actual);
    }

}