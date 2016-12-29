<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetIdStartsAsNull()
    {
        $expected = null;

        $user = new User();

        $actual = $user->getId();

        $this->assertEquals($expected, $actual);
    }

    public function testSetUsernameAndGetUsername()
    {
        $expected = 'username';

        $user = new User();
        $user->setUsername('username');

        $actual = $user->getUsername();

        $this->assertEquals($expected, $actual);
    }

    public function testSetPasswordAndGetPassword()
    {
        $expected = 'password';

        $user = new User();
        $user->setPassword('password');

        $actual = $user->getPassword();

        $this->assertEquals($expected, $actual);
    }

    public function testSetEmailAndGetEmail()
    {
        $expected = 'email';

        $user = new User();
        $user->setEmail('email');

        $actual = $user->getEmail();

        $this->assertEquals($expected, $actual);
    }

    public function testSetIsActiveAndGetIsActive()
    {
        $expected = true;

        $user = new User();
        $user->setIsActive(true);

        $actual = $user->getIsActive();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testSetUsernameAndGetUsernameTypeError()
    {
        $expected = 2;

        $user = new User();
        $user->setUsername(2);

        $actual = $user->getUsername();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testSetPasswordAndGetPasswordTypeError()
    {
        $expected = 1;

        $user = new User();
        $user->setPassword(1);

        $actual = $user->getPassword();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testSetEmailAndGetEmailTypeError()
    {
        $expected = null;

        $user = new User();
        $user->setEmail(null);

        $actual = $user->getEmail();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testSetIsActiveAndGetIsActiveTypeError()
    {
        $expected = 'isActive';

        $user = new User();
        $user->setIsActive('isActive');

        $actual = $user->getIsActive();

        $this->assertEquals($expected, $actual);
    }

    public function testGetSalt(){
        $expected = null;

        $user = new User();

        $actual = $user->getSalt();

        $this->assertEquals($expected, $actual);
    }

    public function testGetRoles(){
        $expected = ['ROLE_USER'];

        $user = new User();

        $actual = $user->getRoles();

        $this->assertEquals($expected, $actual);
    }

    public function testEraseCredentials(){
        $expected = null;

        $user = new User();

        $actual = $user->eraseCredentials();

        $this->assertEquals($expected, $actual);
    }

    public function testSerialize(){
        $expected = [
            null,
            'username',
            'password',
        ];

        $user = new User();
        $user->setUsername('username');
        $user->setPassword('password');

        $serialized = $user->serialize();

        $actual = unserialize($serialized);

        $this->assertEquals($expected, $actual);
    }

    public function testUnserialize(){
        $expected = [
            2,
            'username2',
            'password2',
        ];

        $user = new User();

        $serialized = serialize([
            2,
            'username2',
            'password2',
        ]);

        $user->unserialize($serialized);

        $actual = [
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testUnserializeTypeError(){
        $expected = [
            2,
            'username2',
            'password2',
        ];

        $user = new User();

        $serialized = serialize('cereal');

        $user->unserialize($serialized);

        $actual = [
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testUnserializeTypeError2(){
        $expected = [
            2,
            'username2',
            'password2',
        ];

        $user = new User();

        $serialized = serialize([]);

        $user->unserialize($serialized);

        $actual = [
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testUnserializeTypeError3(){
        $expected = [
            2,
            'username2',
            'password2',
        ];

        $user = new User();

        $serialized = serialize(['id', 'u', 'p']);

        $user->unserialize($serialized);

        $actual = [
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testUnserializeTypeError4(){
        $expected = [
            2,
            'username2',
            'password2',
        ];

        $user = new User();

        $serialized = serialize([0, 1, 'p']);

        $user->unserialize($serialized);

        $actual = [
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException TypeError
     */
    public function testUnserializeTypeError5(){
        $expected = [
            2,
            'username2',
            'password2',
        ];

        $user = new User();

        $serialized = serialize([0, 'u', 2]);

        $user->unserialize($serialized);

        $actual = [
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
        ];

        $this->assertEquals($expected, $actual);
    }
}
