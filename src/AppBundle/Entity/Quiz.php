<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="AppBundle\Repositories\QuizRepository")
 * @Table(name="quiz")
 */
class Quiz 
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $text;
    
    protected $questions;

    function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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

    public function setText( $text )
    {
      if (!is_string($text)) {
          throw new \TypeError();
      } 
      $this->text = $text;
      
    }

    public function getText()
    {
      return $this->text;
    }
}