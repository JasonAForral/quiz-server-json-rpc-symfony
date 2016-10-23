<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;

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
            throw new \TypeError();
        }

        return $questions[mt_rand(0, count($questions) - 1)];
    }
}