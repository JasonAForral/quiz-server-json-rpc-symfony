<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

        //$question = $entityManager->getRepository('AppBundle:Question')->getRandomQuestion();

        

        $response = [
            'jsonrpc' => '2.0',
            'result' => [
                  'question' => '',
                  'answers' => [
                      [
                          'id' => 1
                      ],
                      [
                          'id' => 3
                      ],
                      [
                          'id' => 4
                      ],
                      [
                          'id' => 2
                      ],
                  ],
              ],
            'id' => $id,
        ];

        return new JsonResponse($response);
    }
}
