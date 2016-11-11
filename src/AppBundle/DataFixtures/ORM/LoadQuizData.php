<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\{
    AbstractFixture,
    OrderedFixtureInterface
};
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Quiz;

class LoadQuizData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $quizzes = [
            [
                'text' => 'State Capitals',
                'reference' => 'state-capitals',
            ],
            [
                'text' => 'Atomic Numbers',
                'reference' => 'atomic-numbers',
            ],
        ];

        foreach($quizzes as $quizData) {
            $quiz = new Quiz();

            $quizText = $quizData['text'];
            $quiz->setText($quizText);

            $manager->persist($quiz);
            $manager->flush();

            $reference = 'quiz-' . $quizData['reference'];

            $this->addReference($reference, $quiz);
        }
    }

        public function getOrder()
    {
        return 1;
    }
}