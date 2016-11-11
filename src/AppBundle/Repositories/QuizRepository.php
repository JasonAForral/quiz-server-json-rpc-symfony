<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use AppBundle\Exceptions\NoQuizzesException;

class QuizRepository extends EntityRepository
{
    public function getQuizzes()
    {
        $quizzes = $this->getEntityManager()
            ->createQuery(
                'SELECT quiz FROM AppBundle:Quiz quiz'
            )
            ->getResult();
        
        if (0 === count($quizzes)) {
            throw new NoQuizzesException();
        }

        return $quizzes;
    }
}