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
                'reference' => 'montgomery',
            ],
            [
                'state' => 'Alaska',
                'reference' => 'juneau',
            ],
            [
                'state' => 'Arizona',
                'reference' => 'phoenix',
            ],
            [
                'state' => 'Arkansas',
                'reference' => 'little-rock',
            ],
            [
                'state' => 'California',
                'reference' => 'sacramento',
            ],
            [
                'state' => 'Colorado',
                'reference' => 'denver',
            ],
            [
                'state' => 'Connecticut',
                'reference' => 'hartford',
            ],
            [
                'state' => 'Delaware',
                'reference' => 'dover',
            ],
            [
                'state' => 'District of Columbia',
                'reference' => 'washington',
            ],
            [
                'state' => 'Florida',
                'reference' => 'tallahassee',
            ],
            [
                'state' => 'Georgia',
                'reference' => 'atlanta',
            ],
            [
                'state' => 'Hawaii',
                'reference' => 'honolulu',
            ],
            [
                'state' => 'Idaho',
                'reference' => 'boise',
            ],
            [
                'state' => 'Illinois',
                'reference' => 'springfield',
            ],
            [
                'state' => 'Indiana',
                'reference' => 'indianapolis',
            ],
            [
                'state' => 'Iowa',
                'reference' => 'des-moines',
            ],
            [
                'state' => 'Kansas',
                'reference' => 'topeka',
            ],
            [
                'state' => 'Kentucky',
                'reference' => 'frankfort',
            ],
            [
                'state' => 'Louisiana',
                'reference' => 'baton-rouge',
            ],
            [
                'state' => 'Maine',
                'reference' => 'augusta',
            ],
            [
                'state' => 'Maryland',
                'reference' => 'annapolis',
            ],
            [
                'state' => 'Massachusetts',
                'reference' => 'boston',
            ],
            [
                'state' => 'Michigan',
                'reference' => 'lansing',
            ],
            [
                'state' => 'Minnesota',
                'reference' => 'saint-paul',
            ],
            [
                'state' => 'Mississippi',
                'reference' => 'jackson',
            ],
            [
                'state' => 'Missouri',
                'reference' => 'jefferson-city',
            ],
            [
                'state' => 'Montana',
                'reference' => 'helena',
            ],
            [
                'state' => 'Nebraska',
                'reference' => 'lincoln',
            ],
            [
                'state' => 'Nevada',
                'reference' => 'carson-city',
            ],
            [
                'state' => 'New Hampshire',
                'reference' => 'concord',
            ],
            [
                'state' => 'New Jersey',
                'reference' => 'trenton',
            ],
            [
                'state' => 'New Mexico',
                'reference' => 'santa-fe',
            ],
            [
                'state' => 'New York',
                'reference' => 'albany',
            ],
            [
                'state' => 'North Carolina',
                'reference' => 'raleigh',
            ],
            [
                'state' => 'North Dakota',
                'reference' => 'bismarck',
            ],
            [
                'state' => 'Ohio',
                'reference' => 'columbus',
            ],
            [
                'state' => 'Oklahoma',
                'reference' => 'oklahoma-city',
            ],
            [
                'state' => 'Oregon',
                'reference' => 'salem',
            ],
            [
                'state' => 'Pennsylvania',
                'reference' => 'harrisburg',
            ],
            [
                'state' => 'Rhode Island',
                'reference' => 'providence',
            ],
            [
                'state' => 'South Carolina',
                'reference' => 'columbia',
            ],
            [
                'state' => 'South Dakota',
                'reference' => 'pierre',
            ],
            [
                'state' => 'Tennessee',
                'reference' => 'nashville',
            ],
            [
                'state' => 'Texas',
                'reference' => 'austin',
            ],
            [
                'state' => 'Utah',
                'reference' => 'salt-lake-city',
            ],
            [
                'state' => 'Vermont',
                'reference' => 'montpelier',
            ],
            [
                'state' => 'Washington',
                'reference' => 'olympia',
            ],
            [
                'state' => 'West Virginia',
                'reference' => 'charleston',
            ],
            [
                'state' => 'Wisconsin',
                'reference' => 'madison',
            ],
            [
                'state' => 'Wyoming',
                'reference' => 'cheyenne',
            ],
        ];

        foreach($questions as $questionData) {
            $question = new Question();

            $questionText = 'What is the capital of ' . $questionData['state'] . '?';
            $question->setText($questionText);

            $reference = 'answer-' . $questionData['reference'];
            $question->setAnswer($this->getReference($reference));

            $manager->persist($question);
            $manager->flush();
        }

        // $question = new Question();
        // $question->setText('What is the capital of Oregon?');
        // $question->setAnswer($this->getReference('answer-salem'));

        // $manager->persist($question);
        // $manager->flush();

        // $this->addReference('question-oregon-capital', $question);
    }

    public function getOrder()
    {
        return 2;
    }
}