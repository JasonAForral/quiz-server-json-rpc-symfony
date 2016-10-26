<?php

namespace AppBundle\Utilities;

class Shuffler
{
    static public function arrayShuffle(array $array)
    {
        $count = count($array);
        $shuffledArray = [];

        for($i = $count; $i--;){
            $takeIndex = mt_rand(0, $i);
            $shuffledArray[] = array_splice($array, $takeIndex, 1)[0]; 
        }

        return $shuffledArray;
    }
}