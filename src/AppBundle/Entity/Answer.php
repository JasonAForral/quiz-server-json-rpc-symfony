<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity(repositoryClass="AppBundle\Repositories\AnswerRepository")
 * @Table(name="answer")
 */
class Answer
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

    public function getId()
    {
        return $this->id;
    }

    public function setText($text)
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