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
                'text' => 'Albany',
                'reference' => 'albany',
            ],
            [
                'text' => 'Annapolis',
                'reference' => 'annapolis',
            ],
            [
                'text' => 'Atlanta',
                'reference' => 'atlanta',
            ],
            [
                'text' => 'Augusta',
                'reference' => 'augusta',
            ],
            [
                'text' => 'Austin',
                'reference' => 'austin',
            ],
            [
                'text' => 'Baton Rouge',
                'reference' => 'baton-rouge',
            ],
            [
                'text' => 'Bismarck',
                'reference' => 'bismarck',
            ],
            [
                'text' => 'Boise',
                'reference' => 'boise',
            ],
            [
                'text' => 'Boston',
                'reference' => 'boston',
            ],
            [
                'text' => 'Carson City',
                'reference' => 'carson-city',
            ],
            [
                'text' => 'Charleston',
                'reference' => 'charleston',
            ],
            [
                'text' => 'Cheyenne',
                'reference' => 'cheyenne',
            ],
            [
                'text' => 'Columbia',
                'reference' => 'columbia',
            ],
            [
                'text' => 'Columbus',
                'reference' => 'columbus',
            ],
            [
                'text' => 'Concord',
                'reference' => 'concord',
            ],
            [
                'text' => 'Denver',
                'reference' => 'denver',
            ],
            [
                'text' => 'Des Moines',
                'reference' => 'des-moines',
            ],
            [
                'text' => 'Dover',
                'reference' => 'dover',
            ],
            [
                'text' => 'Frankfort',
                'reference' => 'frankfort',
            ],
            [
                'text' => 'Harrisburg',
                'reference' => 'harrisburg',
            ],
            [
                'text' => 'Hartford',
                'reference' => 'hartford',
            ],
            [
                'text' => 'Helena',
                'reference' => 'helena',
            ],
            [
                'text' => 'Honolulu',
                'reference' => 'honolulu',
            ],
            [
                'text' => 'Indianapolis',
                'reference' => 'indianapolis',
            ],
            [
                'text' => 'Jackson',
                'reference' => 'jackson',
            ],
            [
                'text' => 'Jefferson City',
                'reference' => 'jefferson-city',
            ],
            [
                'text' => 'Juneau',
                'reference' => 'juneau',
            ],
            [
                'text' => 'Lansing',
                'reference' => 'lansing',
            ],
            [
                'text' => 'Lincoln',
                'reference' => 'lincoln',
            ],
            [
                'text' => 'Little Rock',
                'reference' => 'little-rock',
            ],
            [
                'text' => 'Madison',
                'reference' => 'madison',
            ],
            [
                'text' => 'Montgomery',
                'reference' => 'montgomery',
            ],
            [
                'text' => 'Montpelier',
                'reference' => 'montpelier',
            ],
            [
                'text' => 'Nashville',
                'reference' => 'nashville',
            ],
            [
                'text' => 'Oklahoma City',
                'reference' => 'oklahoma-city',
            ],
            [
                'text' => 'Olympia',
                'reference' => 'olympia',
            ],
            [
                'text' => 'Phoenix',
                'reference' => 'phoenix',
            ],
            [
                'text' => 'Pierre',
                'reference' => 'pierre',
            ],
            [
                'text' => 'Providence',
                'reference' => 'providence',
            ],
            [
                'text' => 'Raleigh',
                'reference' => 'raleigh',
            ],
            [
                'text' => 'Richmond',
                'reference' => 'richmond',
            ],
            [
                'text' => 'Sacramento',
                'reference' => 'sacramento',
            ],
            [
                'text' => 'Saint Paul',
                'reference' => 'saint-paul',
            ],
            [
                'text' => 'Salem',
                'reference' => 'salem',
            ],
            [
                'text' => 'Salt Lake City',
                'reference' => 'salt-lake-city',
            ],
            [
                'text' => 'Santa Fe',
                'reference' => 'santa-fe',
            ],
            [
                'text' => 'Springfield',
                'reference' => 'springfield',
            ],
            [
                'text' => 'Tallahassee',
                'reference' => 'tallahassee',
            ],
            [
                'text' => 'Topeka',
                'reference' => 'topeka',
            ],
            [
                'text' => 'Trenton',
                'reference' => 'trenton',
            ],
            [
                'text' => 'Washington',
                'reference' => 'washington',
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