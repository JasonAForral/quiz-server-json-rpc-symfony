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
        $question = new Question();
        $question->setText('What is the capital of Oregon?');
        $question->setAnswer($this->getReference('answer-salem'));

        $manager->persist($question);
        $manager->flush();

        $this->addReference('question-oregon-capital', $question);
    }

    public function getOrder()
    {
        return 2;
    }
}