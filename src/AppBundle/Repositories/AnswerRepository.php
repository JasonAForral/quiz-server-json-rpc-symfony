<?php

namespace AppBundle\Repositories;

use AppBundle\Entity\Answer;
use AppBundle\Exceptions\TooFewAnswersException;
use Doctrine\ORM\EntityRepository;

class AnswerRepository extends EntityRepository
{
    public function getWrongAnswers(Answer $rightAnswer)
    {   
        $allAnswers = $this->getEntityManager()
            ->createQuery(
                'SELECT answer FROM AppBundle:Answer answer'
            )
            ->getResult();

        if (4 > count($allAnswers)) {
          throw new TooFewAnswersException();
        }

        $wrongAnswers = [];

        while (3 > count($wrongAnswers)) {
            $randomAnswer = $allAnswers[mt_rand(0, count($allAnswers) - 1)];

            if ($randomAnswer->getId() !== $rightAnswer->getId()) {

                $length = count($wrongAnswers);
                $isDifferent = true;
                for ($i = 0; $length > $i; ++$i) {
                    if ($randomAnswer->getId() === $wrongAnswers[$i]->getId()){
                      $isDifferent = false;
                    }
                }

                if ($isDifferent) {
                    $wrongAnswers[] = $randomAnswer;
                }
            }
        }

        return $wrongAnswers;
    }
}