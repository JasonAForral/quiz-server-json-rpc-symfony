<?php

namespace AppBundle\Repositories;

use AppBundle\Entity\Question;
use AppBundle\Exceptions\TooFewAnswersException;
use AppBundle\Utilities\Shuffler;
use Doctrine\ORM\EntityRepository;

class AnswerRepository extends EntityRepository
{
    public function getPossibleAnswers(Question $question)
    {
        $rightAnswer = $question->getAnswer();
        $quizId = $question->getQuiz()->getId();

        $query = 'SELECT DISTINCT answer FROM AppBundle:Answer answer';
        $query .= ' JOIN answer.questions questions';
        $query .= ' JOIN questions.quiz quiz';
        $query .= ' WHERE quiz.id = ' . $quizId;

        $allAnswers = $this->getEntityManager()
            ->createQuery($query)
            ->getResult();

        if (4 > count($allAnswers)) {
          throw new TooFewAnswersException();
        }

        $answers = [$rightAnswer];

        while (4 > count($answers)) {
            $randomAnswer = $allAnswers[mt_rand(0, count($allAnswers) - 1)];

            if ($randomAnswer->getId() !== $rightAnswer->getId()) {

                $length = count($answers);
                $isDifferent = true;
                for ($i = 0; $length > $i; ++$i) {
                    if ($randomAnswer->getId() === $answers[$i]->getId()){
                      $isDifferent = false;
                    }
                }

                if ($isDifferent) {
                    $answers[] = $randomAnswer;
                }
            }
        }

        $answers = Shuffler::arrayShuffle($answers);

        return $answers;
    }
}