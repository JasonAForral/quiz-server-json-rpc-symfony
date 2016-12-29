<?php

namespace AppBundle\Tests\Utilities;

use AppBundle\Utilities\Shuffler;

class ShufflerTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayShuffler()
    {
        $expected = [];

        $actual = Shuffler::arrayShuffle([]);

        $this->assertEquals($expected, $actual);
    }

    public function testArrayShufflerArray()
    {
        mt_srand(0);

        $expected = [2, 3, 4, 0, 1];

        $actual = Shuffler::arrayShuffle([0, 1, 2, 3, 4]);

        $this->assertEquals($expected, $actual);
    }

    public function testArrayShufflerArray1()
    {
        mt_srand(1);

        $expected = [2, 0, 4, 3, 1];

        $actual = Shuffler::arrayShuffle([0, 1, 2, 3, 4]);

        $this->assertEquals($expected, $actual);
    }

    public function testArrayShufflerArray2()
    {
        mt_srand(2);

        $expected = [2, 4, 3, 1, 0];

        $actual = Shuffler::arrayShuffle([0, 1, 2, 3, 4]);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testArrayShufflerNotArray()
    {
        mt_srand(3);

        $expected = [2, 4, 3, 0, 1];

        $actual = Shuffler::arrayShuffle('hat');

        $this->assertEquals($expected, $actual);
    }
}
