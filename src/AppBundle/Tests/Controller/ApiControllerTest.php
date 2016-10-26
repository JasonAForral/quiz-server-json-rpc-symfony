<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Linters\JsonRpcLinter;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
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

    public function testApiReturns200()
    {
        $expected = 200;

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $actual = $client->getResponse()->getStatusCode();

        $this->assertEquals($expected, $actual);
    }

    public function testApiReturns405GetRequest()
    {
        $expected = 405;

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'GET',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $actual = $client->getResponse()->getStatusCode();

        $this->assertEquals($expected, $actual);
    }

    public function testApiReturnsJsonRpcErrorNoQuestionsException() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => 1,
                'message' => 'No Questions Exception'
            ],
            'id' => 1,
        ];

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => 1,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testApiReturnsJsonRpcErrorTooFewAnswersException() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => 2,
                'message' => 'Too Few Answers Exception'
            ],
            'id' => 1,
        ];

        $question = new Question();
        $question->setText('Where are my answers?');

        $answer = new Answer();
        $answer->setText('In the database');
        $question->setAnswer($answer);

        $this->entityManager->persist($question);
        $this->entityManager->persist($answer);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => 1,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testApiLints()
    {
        $expected = true;

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonRpcLintResult = JsonRpcLinter::getResult(json_decode($content, true));

        $actual = $jsonRpcLintResult->getValid();

        $this->assertEquals($expected, $actual);
    }

    public function testIdMatches()
    {
        $expected = '1';

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = $jsonDecoded['id'];

        $this->assertEquals($expected, $actual);
    }

    public function testIdMatches2()
    {
        $expected = '2';

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '2',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = $jsonDecoded['id'];

        $this->assertEquals($expected, $actual);
    }

    public function testResultHasQuestionAndAnswers()
    {
        $expected = true;

        $question = new Question();
        $question->setText('Do I have a question and answer?');
        $this->entityManager->persist($question);

        $answer = new Answer();
        $answer->setText('A');
        $question->setAnswer($answer);
        $this->entityManager->persist($answer);

        $answer2 = new Answer();
        $answer2->setText('B');
        $this->entityManager->persist($answer2);

        $answer3 = new Answer();
        $answer3->setText('C');
        $this->entityManager->persist($answer3);

        $answer4 = new Answer();
        $answer4->setText('D');
        $this->entityManager->persist($answer4);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $questionExists = array_key_exists('question', $jsonDecoded['result']);
        
        $answersExists = array_key_exists('answers', $jsonDecoded['result']);

        $actual = $questionExists && $answersExists;

        $this->assertEquals($expected, $actual);
    }

    public function testPullQuestionAndAnswersFromRepository()
    {
        mt_srand(1);

        $expected = [3, 2, 1, 4];

        $question = new Question();
        $question->setText('Where is my stuff?');
        $this->entityManager->persist($question);

        $rightAnswer = new Answer();
        $rightAnswer->setText('X');
        $question->setAnswer($rightAnswer);
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('O');
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Triangle');
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Square');
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = array_map(function ($answer) {
            return $answer['id'];
        }, $jsonDecoded['result']['answers']);

        $this->assertEquals($expected, $actual);
    }

    public function testPullQuestionAndAnswersFromRepository2()
    {
        mt_srand(2);

        $expected = [4, 3, 1, 2];

        $question = new Question();
        $question->setText('Is my stuff still there?');
        $this->entityManager->persist($question);

        $rightAnswer = new Answer();
        $rightAnswer->setText('Yes');
        $question->setAnswer($rightAnswer);
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('Blue');
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Up');
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Seven');
        $this->entityManager->persist($wrongAnswer3);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = array_map(function ($answer) {
            return $answer['id'];
        }, $jsonDecoded['result']['answers']);

        $this->assertEquals($expected, $actual);
    }

    
}
