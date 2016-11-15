<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use AppBundle\Exceptions\NoQuizzesException;

class QuizRepository extends EntityRepository
{
    public function getQuizzes()
    {
        $queryString = 'SELECT quiz FROM AppBundle:Quiz quiz';
        $query = $this->getEntityManager()->createQuery($queryString);
        $quizzes = $query->getResult();

        if (0 >= count($quizzes)) {
            throw new NoQuizzesException();
        }

        return $quizzes;
    }
}