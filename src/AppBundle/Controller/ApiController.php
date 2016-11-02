<?php

namespace AppBundle\Controller;

use AppBundle\Exceptions\ {NoQuestionsException, TooFewAnswersException};
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
                'id' => null,
            ];
            return new JsonResponse($response);
        }

        $method = $jsonDecoded['method'];

        switch($method) {
            case 'newQuestion':
                return $this->newQuestion($id);
            case 'answerQuestion':
                $answerId = $jsonDecoded['params']['answerId'];
                $questionId = $jsonDecoded['params']['questionId'];
                return $this->answerQuestion($answerId, $id, $questionId);
            default:
                return 'error';
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
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => 2,
                    'message' => 'Too Few Answers Exception'
                ],
                'id' => $id,
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
            'jsonrpc' => '2.0',
            'result' => [
                  'question' => [
                      'id' => $question->getId(),
                      'text' => $question->getText(),
                  ],
                  'answers' => $possibleAnswersJson,
              ],
            'id' => $id,
        ];

        return new JsonResponse($response);
    }

    private function answerQuestion($answerId, $id, $questionId)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $correctAnswerId = $entityManager->getRepository('AppBundle:Question')->findOneById($questionId)->getAnswer()->getId();

        $response = [
            'id' => $id,
            'jsonrpc' => '2.0',
            'result' => [
                'answerId' => $correctAnswerId,
            ],
        ];
        
        return new JsonResponse($response);
    }
}
