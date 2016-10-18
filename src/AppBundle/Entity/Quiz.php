<?php

namespace AppBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;

class Quiz 
{
    protected $questions;

    function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId()
    {

    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function addQuestion(Question $question)
    {
        $this->questions->add($question);
    }

    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }
}