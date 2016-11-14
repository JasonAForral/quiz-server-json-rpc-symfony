<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\{
    AbstractFixture,
    OrderedFixtureInterface
};
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Question;

class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $questions = [
            [
                'state' => 'Alabama',
                'capital' => 'montgomery',
            ],
            [
                'state' => 'Alaska',
                'capital' => 'juneau',
            ],
            [
                'state' => 'Arizona',
                'capital' => 'phoenix',
            ],
            [
                'state' => 'Arkansas',
                'capital' => 'little-rock',
            ],
            [
                'state' => 'California',
                'capital' => 'sacramento',
            ],
            [
                'state' => 'Colorado',
                'capital' => 'denver',
            ],
            [
                'state' => 'Connecticut',
                'capital' => 'hartford',
            ],
            [
                'state' => 'Delaware',
                'capital' => 'dover',
            ],
            [
                'state' => 'District of Columbia',
                'capital' => 'washington',
            ],
            [
                'state' => 'Florida',
                'capital' => 'tallahassee',
            ],
            [
                'state' => 'Georgia',
                'capital' => 'atlanta',
            ],
            [
                'state' => 'Hawaii',
                'capital' => 'honolulu',
            ],
            [
                'state' => 'Idaho',
                'capital' => 'boise',
            ],
            [
                'state' => 'Illinois',
                'capital' => 'springfield',
            ],
            [
                'state' => 'Indiana',
                'capital' => 'indianapolis',
            ],
            [
                'state' => 'Iowa',
                'capital' => 'des-moines',
            ],
            [
                'state' => 'Kansas',
                'capital' => 'topeka',
            ],
            [
                'state' => 'Kentucky',
                'capital' => 'frankfort',
            ],
            [
                'state' => 'Louisiana',
                'capital' => 'baton-rouge',
            ],
            [
                'state' => 'Maine',
                'capital' => 'augusta',
            ],
            [
                'state' => 'Maryland',
                'capital' => 'annapolis',
            ],
            [
                'state' => 'Massachusetts',
                'capital' => 'boston',
            ],
            [
                'state' => 'Michigan',
                'capital' => 'lansing',
            ],
            [
                'state' => 'Minnesota',
                'capital' => 'saint-paul',
            ],
            [
                'state' => 'Mississippi',
                'capital' => 'jackson',
            ],
            [
                'state' => 'Missouri',
                'capital' => 'jefferson-city',
            ],
            [
                'state' => 'Montana',
                'capital' => 'helena',
            ],
            [
                'state' => 'Nebraska',
                'capital' => 'lincoln',
            ],
            [
                'state' => 'Nevada',
                'capital' => 'carson-city',
            ],
            [
                'state' => 'New Hampshire',
                'capital' => 'concord',
            ],
            [
                'state' => 'New Jersey',
                'capital' => 'trenton',
            ],
            [
                'state' => 'New Mexico',
                'capital' => 'santa-fe',
            ],
            [
                'state' => 'New York',
                'capital' => 'albany',
            ],
            [
                'state' => 'North Carolina',
                'capital' => 'raleigh',
            ],
            [
                'state' => 'North Dakota',
                'capital' => 'bismarck',
            ],
            [
                'state' => 'Ohio',
                'capital' => 'columbus',
            ],
            [
                'state' => 'Oklahoma',
                'capital' => 'oklahoma-city',
            ],
            [
                'state' => 'Oregon',
                'capital' => 'salem',
            ],
            [
                'state' => 'Pennsylvania',
                'capital' => 'harrisburg',
            ],
            [
                'state' => 'Rhode Island',
                'capital' => 'providence',
            ],
            [
                'state' => 'South Carolina',
                'capital' => 'columbia',
            ],
            [
                'state' => 'South Dakota',
                'capital' => 'pierre',
            ],
            [
                'state' => 'Tennessee',
                'capital' => 'nashville',
            ],
            [
                'state' => 'Texas',
                'capital' => 'austin',
            ],
            [
                'state' => 'Utah',
                'capital' => 'salt-lake-city',
            ],
            [
                'state' => 'Vermont',
                'capital' => 'montpelier',
            ],
            [
                'state' => 'Washington',
                'capital' => 'olympia',
            ],
            [
                'state' => 'West Virginia',
                'capital' => 'charleston',
            ],
            [
                'state' => 'Wisconsin',
                'capital' => 'madison',
            ],
            [
                'state' => 'Wyoming',
                'capital' => 'cheyenne',
            ],
        ];

        foreach($questions as $questionData) {
            $question = new Question();

            $questionText = 'What is the capital of ' . $questionData['state'] . '?';
            $question->setText($questionText);

            $reference = 'answer-' . $questionData['capital'];
            $question->setAnswer($this->getReference($reference));

            $reference2 = 'quiz-state-capitals';
            $question->setQuiz($this->getReference($reference2));
            
            $manager->persist($question);
            $manager->flush();
        }

        $questions2 = [
            [
                'element' => 'Hydrogen',
                'number' => 'one',
            ],
            [
                'element' => 'Helium',
                'number' => 'two',
            ],
            [
                'element' => 'Lithium',
                'number' => 'three',
            ],
            [
                'element' => 'Beryllium',
                'number' => 'four',
            ],
        ];

        foreach($questions2 as $questionData) {
            $question = new Question();

            $questionText = 'What is the atomic number of ' . $questionData['element'] . '?';
            $question->setText($questionText);

            $reference = 'answer-' . $questionData['number'];
            $question->setAnswer($this->getReference($reference));

            $reference2 = 'quiz-atomic-numbers';
            $question->setQuiz($this->getReference($reference2));
            
            $manager->persist($question);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 2;
    }
}