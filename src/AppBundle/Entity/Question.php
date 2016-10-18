<?php

namespace AppBundle\Entity;

class Question 
{
  protected $text;

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
}