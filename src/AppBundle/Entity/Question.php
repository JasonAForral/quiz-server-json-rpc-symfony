<?php

namespace AppBundle\Entity;

class Question 
{
    protected $text;

    public function getId()
    {

    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }
}