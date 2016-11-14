<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use AppBundle\Exceptions\NoQuestionsException;

class QuestionRepository extends EntityRepository
{
    public function getRandomQuestion($quizId = null)
    {

        $query = 'SELECT question FROM AppBundle:Question question';

    //     if (null !== $quizId) {
    //         $query .= ' WHERE Quiz = ' . $quizId;
    //         // var_dump($quizId);
    //         // var_dump($query);
    //    }

        $questions = $this->getEntityManager()
            ->createQuery(
                $query
            )
            ->getResult();
        
        $filteredQuestions = [];

        if (null !== $quizId) {
            foreach ($questions as $question) {
                if ($question->getQuiz()->getId() === $quizId) {
                    array_push($filteredQuestions, $question);
                }
            }
        } else {
            $filteredQuestions = array_slice($questions, 0);
        }

        $count = count($filteredQuestions);

        if (0 === $count) {
            throw new NoQuestionsException();
        }


        return $filteredQuestions[mt_rand(0, $count - 1)];
    }
}