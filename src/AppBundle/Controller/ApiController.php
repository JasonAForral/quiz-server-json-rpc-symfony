<?php

namespace AppBundle\Controller;

use AppBundle\Exceptions\ {NoQuestionsException, TooFewAnswersException};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\ {Controller};
use Symfony\Component\HttpFoundation\ {JsonResponse, Request};

class ApiController extends Controller
{
    /**
     * @Route("/api/", name="api")
     * @Method({"POST"})
     */
    public function apiAction(Request $request)
    {
        $content = $request->getContent();

        $jsonDecoded = json_decode($content, true);

        $id = $jsonDecoded['id'];

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
}
