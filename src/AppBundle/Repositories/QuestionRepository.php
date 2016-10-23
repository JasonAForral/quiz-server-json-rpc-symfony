<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use AppBundle\Exceptions\NoQuestionsException;

class QuestionRepository extends EntityRepository
{
    public function getRandomQuestion()
    {
        $questions = $this->getEntityManager()
            ->createQuery(
                'SELECT question FROM AppBundle:Question question'
            )
            ->getResult();
        
        if (0 === count($questions)) {
            throw new NoQuestionsException();
        }

        return $questions[mt_rand(0, count($questions) - 1)];
    }
}