<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

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
     * @ManyToOne(targetEntity="Answer", inversedBy="questions")
     * @JoinColumn(name="answer_id", referencedColumnName="id", nullable=false)
     */
    protected $answer;

    /**
     * @ManyToOne(targetEntity="Quiz")
     * @JoinColumn(name="quiz_id", referencedColumnName="id", nullable=false)
     */
    protected $quiz;

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

    public function setQuiz(Quiz $quiz){
        $this->quiz = $quiz;
    }

    public function getQuiz(){
        return $this->quiz;
    }
}