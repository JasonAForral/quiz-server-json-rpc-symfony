<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\
    {
        Answer,
        Question,
        Quiz
    };
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
            '/api',
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
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $actual = $client->getResponse()->getStatusCode();

        $this->assertEquals($expected, $actual);
    }

    public function testApiReturnsRpcErrorParseError()
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32700,
                'message' => 'Parse error',
            ],
            'id' => null,
        ];

        $request = 'I like turtles!';

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $request // json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

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
            '/api',
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

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

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
            '/api',
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
            '/api',
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
            '/api',
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
            '/api',
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

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
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

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
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

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
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

    public function testPullQuestionTextFromRepository()
    {
        //mt_srand(3);

        $expected = 'Where is my stuff?';

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

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = $jsonDecoded['result']['question']['text'];

        $this->assertEquals($expected, $actual);
    }

    public function testPullQuestionIdFromRepository()
    {
        mt_srand(3);

        $expected = 1;

        $question = new Question();
        $question->setText('Where is my stuff?');
        $this->entityManager->persist($question);

        $question2 = new Question();
        $question2->setText('Where is the beef?');
        $this->entityManager->persist($question2);

        $rightAnswer = new Answer();
        $rightAnswer->setText('X');
        $question->setAnswer($rightAnswer);
        $this->entityManager->persist($rightAnswer);

        $wrongAnswer1 = new Answer();
        $wrongAnswer1->setText('O');
        $question2->setAnswer($wrongAnswer1);
        $this->entityManager->persist($wrongAnswer1);

        $wrongAnswer2 = new Answer();
        $wrongAnswer2->setText('Triangle');
        $this->entityManager->persist($wrongAnswer2);

        $wrongAnswer3 = new Answer();
        $wrongAnswer3->setText('Square');
        $this->entityManager->persist($wrongAnswer3);

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $question2->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = $jsonDecoded['result']['question']['id'];

        $this->assertEquals($expected, $actual);
    }

    public function testPullAnswerTextFromRepository()
    {
        mt_srand(4);

        $expected = ['O', 'Triangle', 'Square', 'X'];

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

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $this->entityManager->flush();

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => '1',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = array_map(function ($answer) {
            return $answer['text'];
        }, $jsonDecoded['result']['answers']);

        $this->assertEquals($expected, $actual);
    }

    public function testAnswerQuestionHasCorrectId()
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

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

        $this->entityManager->flush();

        $request = [
            'id' => '1',
            'jsonrpc' => '2.0',
            'method' => 'answerQuestion',
            'params' => [
                'guessId' => 1,
                'questionId' => 1,
            ],
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $correctIdExists = array_key_exists('correctId', $jsonDecoded['result']);

        $actual = $correctIdExists;

        $this->assertEquals($expected, $actual);
    }
    
    public function testAnswerQuestionReturnsCorrectAnswer()
    {
        $expected = 1;

        $question = new Question();
        $question->setText('Do I have a question and answer?');
        $this->entityManager->persist($question);

        $quiz = new Quiz();
        $quiz->setText('Test Quiz');
        $question->setQuiz($quiz);
        $this->entityManager->persist($quiz);

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
            'id' => '1',
            'jsonrpc' => '2.0',
            'method' => 'answerQuestion',
            'params' => [
                'guessId' => 3,
                'questionId' => 1,
            ],
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = $jsonDecoded['result']['correctId'];

        $this->assertEquals($expected, $actual);
    }

    public function testApiNullIdReturnsInvalidRequest() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32600,
                'message' => 'Invalid Request',
            ],
            'id' => null,
        ];

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'id' => null,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testApiNoMethodReturnsInvalidRequest() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32600,
                'message' => 'Invalid Request',
            ],
            'id' => 1,
        ];

        $request = [
            'jsonrpc' => '2.0',
            'question' => 'newQuestion',
            'id' => 1,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testApiNoJsonRpcReturnsInvalidRequest() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32600,
                'message' => 'Invalid Request',
            ],
            'id' => 1,
        ];

        $request = [
            'jsonrpc' => '2.1',
            'method' => 'newQuestion',
            'id' => 1,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testApiReturnsMethodNotFound() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32601,
                'data' => 'doABarrelRoll not found',
                'message' => 'Method not found',
            ],
            'id' => 1,
        ];

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'doABarrelRoll',
            'id' => 1,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testApiReturnsInvalidParamsNoParams() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32602,
                'data' => 'Missing params',
                'message' => 'Invalid params',
            ],
            'id' => 1,
        ];

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'answerQuestion',
            
            'id' => 1,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testApiReturnsInvalidParamsNoQuestion() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32602,
                'data' => 'Missing question',
                'message' => 'Invalid params',
            ],
            'id' => 1,
        ];

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'answerQuestion',
            'params' => [
                'guessId' => 1,
            ],
            'id' => 1,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testApiReturnsInvalidParamsNoAnswer() 
    {
        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32602,
                'data' => 'Missing answer',
                'message' => 'Invalid params',
            ],
            'id' => 1,
        ];

        $request = [
            'jsonrpc' => '2.0',
            'method' => 'answerQuestion',
            'params' => [
                'questionId' => 1,
            ],
            'id' => 1,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $actual = json_decode($content, true);

        $this->assertEquals($expected, $actual);
    }

    public function testGetQuizzesReturnsQuizzes()
    {
        $expected = [
            'jsonrpc' => '2.0',
            'result' => [
                'quizzes' => [
                    [
                        'id' => 1,
                        'text' => 'State Capitals'
                    ],
                    [
                        'id' => 2,
                        'text' => 'Atomic Numbers'
                    ],
                ],
            ],
            'id' => 1,
        ];

        $quiz0 = new Quiz();
        $quiz0->setText('State Capitals');
        $this->entityManager->persist($quiz0);

        $quiz1 = new Quiz();
        $quiz1->setText('Atomic Numbers');
        $this->entityManager->persist($quiz1);

        $this->entityManager->flush();

        $request = [
            'id' => 1,
            'jsonrpc' => '2.0',
            'method' => 'getQuizzes',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = $jsonDecoded;

        $this->assertEquals($expected, $actual);
    }

    public function testGetQuizzesReturnsNoQuizzesException()
    {

        $expected = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => 3,
                'message' => 'No Quizzes Exception',
            ],
            'id' => 1,
        ];

        $request = [
            'id' => 1,
            'jsonrpc' => '2.0',
            'method' => 'getQuizzes',
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = $jsonDecoded;

        $this->assertEquals($expected, $actual);
    }

    public function testResultCameFromeSpecificQuiz()
    {
        mt_srand(1);

        $expected = [
            'id' => 5,
            'text' => 'Which Number Is 1?',
            ];

        $question1 = new Question();
        $question1->setText('Which Letter Is A?');
        $this->entityManager->persist($question1);

        $question2 = new Question();
        $question2->setText('Which Letter Is B?');
        $this->entityManager->persist($question2);

        $question3 = new Question();
        $question3->setText('Which Letter Is C?');
        $this->entityManager->persist($question3);

        $question4 = new Question();
        $question4->setText('Which Letter Is D?');
        $this->entityManager->persist($question4);

        $questionA = new Question();
        $questionA->setText('Which Number Is 1?');
        $this->entityManager->persist($questionA);

        $answer1 = new Answer();
        $answer1->setText('A');
        $question1->setAnswer($answer1);
        $this->entityManager->persist($answer1);

        $answer2 = new Answer();
        $answer2->setText('B');
        $question2->setAnswer($answer2);
        $this->entityManager->persist($answer2);

        $answer3 = new Answer();
        $answer3->setText('C');
        $question3->setAnswer($answer3);
        $this->entityManager->persist($answer3);

        $answer4 = new Answer();
        $answer4->setText('D');
        $question4->setAnswer($answer4);
        $this->entityManager->persist($answer4);

        $answerA = new Answer();
        $answerA->setText('1');
        $questionA->setAnswer($answerA);
        $this->entityManager->persist($answerA);

        $quiz1 = new Quiz();
        $quiz1->setText('Test Quiz 1');
        $question1->setQuiz($quiz1);
        $question2->setQuiz($quiz1);
        $question3->setQuiz($quiz1);
        $question4->setQuiz($quiz1);
        $this->entityManager->persist($quiz1);

        $quizA = new Quiz();
        $quizA->setText('Test Quiz A');
        $questionA->setQuiz($quizA);
        $this->entityManager->persist($quizA);

        $this->entityManager->flush();

        $request = [
            'id' => 1,
            'jsonrpc' => '2.0',
            'method' => 'newQuestion',
            'params' => [
                'quizId' => 2,
            ],
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/api',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($request)
        );

        $content = $client->getResponse()->getContent();

        $jsonDecoded = json_decode($content, true);

        $actual = $jsonDecoded['result']['question'];

        $this->assertEquals($expected, $actual);
    }
}
