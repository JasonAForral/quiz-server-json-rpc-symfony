<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Answer;
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

        $expected = [1, 3, 4, 2];

        $rightAnswer = new Answer();
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
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

    // public function testPullQuestionAndAnswersFromRepository2()
    // {
    //     mt_srand(2);

    //     $expected = [1, 2, 3, 4];

    //     $rightAnswer = new Answer();
    //     $this->entityManager->persist($rightAnswer);

    //     $wrongAnswer1 = new Answer();
    //     $this->entityManager->persist($wrongAnswer1);

    //     $wrongAnswer2 = new Answer();
    //     $this->entityManager->persist($wrongAnswer2);

    //     $wrongAnswer3 = new Answer();
    //     $this->entityManager->persist($wrongAnswer3);

    //     $this->entityManager->flush();

    //     $request = [
    //         'jsonrpc' => '2.0',
    //         'method' => 'newQuestion',
    //         'id' => '1',
    //     ];

    //     $client = static::createClient();

    //     $client->request(
    //         'POST',
    //         '/api/',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json'],
    //         json_encode($request)
    //     );

    //     $content = $client->getResponse()->getContent();

    //     $jsonDecoded = json_decode($content, true);

    //     $actual = array_map(function ($answer) {
    //         return $answer['id'];
    //     }, $jsonDecoded['result']['answers']);

    //     $this->assertEquals($expected, $actual);
    // }

    
}
