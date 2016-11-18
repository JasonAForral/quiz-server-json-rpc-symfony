<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Table(name="app_users")
 * @Entity(repositoryClass="AppBundle\Repositories\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=25, unique=true)
     */
    protected $username;

    /**
     * @Column(type="string", length=64)
     */
    protected $password;

    /**
     * @Column(type="string", length=60, unique=true)
     */
    protected $email;

    /**
     * @Column(name="is_active", type="boolean")
     */
    protected $isActive;

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        if (!is_string($username)){
            throw new \TypeError();
        }
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        if (!is_string($password)){
            throw new \TypeError();
        }
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        if (!is_string($email)){
            throw new \TypeError();
        }
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setIsActive($isActive)
    {
        if (!is_bool($isActive)){
            throw new \TypeError();
        }
        $this->isActive = $isActive;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function getSalt()
    {
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);
        if (!is_array($unserialized)) {
            throw new \TypeError();
        }

        if (3 !== count($unserialized)) {
            throw new \TypeError();
        }

        if (!is_int($unserialized[0])) {
            throw new \TypeError();
        }

        if (!is_string($unserialized[1])) {
            throw new \TypeError();
        }

        if (!is_string($unserialized[2])) {
            throw new \TypeError();
        }

        list (
            $this->id,
            $this->username,
            $this->password,
        ) = $unserialized;
    }
}