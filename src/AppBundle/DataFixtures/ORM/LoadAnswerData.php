<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\{
    AbstractFixture,
    OrderedFixtureInterface
};
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Answer;

class LoadAnswerData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $answers = [
            [
                'text' => 'Salem',
                'reference' => 'salem',
            ],
            [
                'text' => 'Olympia',
                'reference' => 'olympia',
            ],
            [
                'text' => 'Sacramento',
                'reference' => 'sacramento',
            ],
            [
                'text' => 'Honolulu',
                'reference' => 'honolulu',
            ],
        ];

        foreach($answers as $answerData) {
            $answer = new Answer();
            $answer->setText($answerData['text']);
            
            $manager->persist($answer);
            $manager->flush();

            $reference = 'answer-' . $answerData['reference'];

            $this->addReference($reference, $answer);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}