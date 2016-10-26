<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
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

    /**
     * @Column(type="string")
     */
    protected $text;
    
    /**
     * @ManyToOne(targetEntity="Answer")
     * @JoinColumn(name="answer_id", referencedColumnName="id", nullable=false)
     */
    protected $answer;

    public function getId()
    {
        return $this->id;
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

    public function setAnswer(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function getAnswer()
    {
        return $this->answer;
    }
}