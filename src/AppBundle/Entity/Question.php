<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity(repositoryClass="AppBundle\Repositories\QuestionRepository")
 * @Table(name="question")
 */
class Question
{

    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $text;
    
    protected $answer;

    public function getId()
    {
        
    }

    public function setText( $text )
    {
      if (is_string($text)) {
          $this->text = $text;
      } else {
          throw new \TypeError();
      }
    }

    public function getText()
    {
      return $this->text;
    }

    public function setAnswer(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function getAnswer()
    {
        return $this->answer;
    }
}