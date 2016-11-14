<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use AppBundle\Exceptions\NoQuestionsException;

class QuestionRepository extends EntityRepository
{
    public function getRandomQuestion($quizId = null)
    {

        $query = 'SELECT question FROM AppBundle:Question question';

        if (null !== $quizId) {
            $query .= ' JOIN question.quiz quiz';
            $query .= ' WHERE quiz.id = ' . $quizId;
        }

        $questions = $this->getEntityManager()
            ->createQuery(
                $query
            )
            ->getResult();

        $count = count($questions);

        if (0 === $count) {
            throw new NoQuestionsException();
        }

        return $questions[mt_rand(0, $count - 1)];
    }
}