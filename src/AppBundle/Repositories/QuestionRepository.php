<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use AppBundle\Exceptions\NoQuestionsException;

class QuestionRepository extends EntityRepository
{
    public function getRandomQuestion($quizId = null)
    {
        $queryString = 'SELECT question FROM AppBundle:Question question';

        if (null !== $quizId) {
            $queryString .= ' JOIN question.quiz quiz';
            $queryString .= ' WHERE quiz.id = :quizId';
            $query = $this->getEntityManager()->createQuery($queryString);
            $query->setParameter('quizId', $quizId);
        } else {
            $query = $this->getEntityManager()->createQuery($queryString);
        }

        $questions = $query->getResult();

        $count = count($questions);

        if (0 === $count) {
            throw new NoQuestionsException();
        }

        return $questions[mt_rand(0, $count - 1)];
    }
}