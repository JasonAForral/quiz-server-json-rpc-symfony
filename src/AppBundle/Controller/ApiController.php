<?php

namespace AppBundle\Controller;

use AppBundle\Exceptions\ {
        NoQuestionsException, 
        NoQuizzesException,
        TooFewAnswersException
    };
use AppBundle\Linters\JsonRpcLinter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\ {Controller};
use Symfony\Component\HttpFoundation\ {JsonResponse, Request};

class ApiController extends Controller
{
    /**
     * @Route("/api", name="api")
     * @Method({"POST"})
     */
    public function apiAction(Request $request)
    {
        $content = $request->getContent();

        $jsonDecoded = json_decode($content, true);

        if (null === $jsonDecoded) {
            $response = [
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => -32700,
                    'message' => 'Parse error',
                ],
                'id' => null,
            ];
            return new JsonResponse($response);
        }

        $id = $jsonDecoded['id'];

        if (!JsonRpcLinter::getResult($jsonDecoded)->getValid()) {
            $response = [
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => -32600,
                    'message' => 'Invalid Request',
                ],
                'id' => $id,
            ];
            return new JsonResponse($response);
        }

        $method = $jsonDecoded['method'];

        switch($method) {
            case 'newQuestion':
                return $this->newQuestion($id);

            case 'answerQuestion':
                if (!array_key_exists('params', $jsonDecoded)) {
                    return $this->invalidParams($id, 'Missing params');
                } else if (!array_key_exists('questionId', $jsonDecoded['params'])) {
                    return $this->invalidParams($id, 'Missing question');
                } else if (!array_key_exists('guessId', $jsonDecoded['params'])) {
                    return $this->invalidParams($id, 'Missing answer');
                }
                
                $guessId = $jsonDecoded['params']['guessId'];
                $questionId = $jsonDecoded['params']['questionId'];
                return $this->answerQuestion($guessId, $id, $questionId);

            case 'getQuizzes':
                return $this->getQuizzes($id);

            default:
                $response = [
                    'jsonrpc' => '2.0',
                    'error' => [
                        'code' => -32601,
                        'data' => $method . ' not found',
                        'message' => 'Method not found',
                    ],
                    'id' => $id,
                ];
                return new JsonResponse($response);
        }
    }
    

    private function newQuestion($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {

            $question = $entityManager->getRepository('AppBundle:Question')->getRandomQuestion();
            
            $rightAnswer = $question->getAnswer();

            $possibleAnswers = $entityManager->getRepository('AppBundle:Answer')->getPossibleAnswers($rightAnswer);

        } catch (NoQuestionsException $noQuestionsException) {

            $response = [
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => 1,
                    'message' => 'No Questions Exception'
                ],
                'id' => $id,
            ];

            return new JsonResponse($response);

        } catch (TooFewAnswersException $tooFewAnswersException) {

            $response = [
                'id' => $id,
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => 2,
                    'message' => 'Too Few Answers Exception'
                ],
            ];

            return new JsonResponse($response);
        }

        $possibleAnswersJson = array_map(function ($answer) {
            return [
                'id' => $answer->getId(),
                'text' => $answer->getText(),
            ];
        }, $possibleAnswers);

        $response = [
            'id' => $id,
            'jsonrpc' => '2.0',
            'result' => [
                  'question' => [
                      'id' => $question->getId(),
                      'text' => $question->getText(),
                  ],
                  'answers' => $possibleAnswersJson,
              ],
        ];

        return new JsonResponse($response);
    }

    private function answerQuestion($guessId, $id, $questionId)
    {
        if (!is_int($guessId)) {
            return $this->invalidParams($id);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $correctId = $entityManager->getRepository('AppBundle:Question')->findOneById($questionId)->getAnswer()->getId();

        $response = [
            'id' => $id,
            'jsonrpc' => '2.0',
            'result' => [
                'correctId' => $correctId,
            ],
        ];
        
        return new JsonResponse($response);
    }

    private function invalidParams($id, $data)
    {
        $response = [
            'id' => $id,
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32602,
                'data' => $data,
                'message' => 'Invalid params',
            ],
        ];

        return new JsonResponse($response);
    }

    private function getQuizzes($id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        try {
            $quizzes = $entityManager->getRepository('AppBundle:Quiz')->getQuizzes();
        } catch (NoQuizzesException $noQuizzesException) {

            $response = [
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => 3,
                    'message' => 'No Quizzes Exception'
                ],
                'id' => $id,
            ];

            return new JsonResponse($response);
        }

        $quizzes = array_map(function ($quiz) {
            return [
                'id' => $quiz->getId(),
                'text' => $quiz->getText(),
            ];
        }, $quizzes);

        $response = [
            'id' => $id,
            'jsonrpc' => '2.0',
            'result' => [
                'quizzes' => $quizzes,
            ],
        ];

        return new JsonResponse($response); 

    }
}
