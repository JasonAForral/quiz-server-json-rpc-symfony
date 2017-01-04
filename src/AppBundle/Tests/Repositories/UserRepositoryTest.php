<?php

namespace AppBundle\Tests\Repositories;

use AppBundle\Entity\User;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    protected $entityManager;
    protected $passwordEncoder;

    protected function setUp()
    {
        parent::setUp();
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $this->passwordEncoder = $this->getContainer()
            ->get('security.password_encoder');

        $this->loadFixtures([]);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testGetUserByUsernameNotFound()
    {
        $expected = null;

        $userRepository = $this->entityManager
            ->getRepository('AppBundle:User')
        ;

        $actual = $userRepository->getUserByUsername('username');

        $this->assertEquals($expected, $actual);
    }

    public function testGetUserByUsername()
    {
        $expected = 'HatTrick';

        $user = new User();
        $user->setUsername('HatTrick');
        
        $password = $this->passwordEncoder->encodePassword($user, 'hathathat');
        $user->setPassword($password);

        $user->setEmail('at@at.at');

        $user->setIsActive(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
            
        $userRepository = $this->entityManager
            ->getRepository('AppBundle:User')
        ;

        $userFound = $userRepository->getUserByUsername('HatTrick');

        $actual = $userFound->getUsername();

        $this->assertEquals($expected, $actual);
    }

    public function testGetUserByUsernameCaseInsensitive()
    {
        $expected = 'HatTrick';

        $user = new User();
        $user->setUsername('HatTrick');
        
        $password = $this->passwordEncoder->encodePassword($user, 'hathathat');
        $user->setPassword($password);

        $user->setEmail('at@at.at');

        $user->setIsActive(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
            
        $userRepository = $this->entityManager
            ->getRepository('AppBundle:User')
        ;

        $userFound = $userRepository->getUserByUsername('hattrick');

        $actual = $userFound->getUsername();

        $this->assertEquals($expected, $actual);
    }

    public function testGetUserByEmailNotFound()
    {
        $expected = null;

        $userRepository = $this->entityManager
            ->getRepository('AppBundle:User')
        ;

        $actual = $userRepository->getUserByEmail('email');

        $this->assertEquals($expected, $actual);
    }

    public function testGetUserByEmail()
    {
        $expected = 'HatTrick';

        $user = new User();
        $user->setUsername('HatTrick');
        
        $password = $this->passwordEncoder->encodePassword($user, 'hathathat');
        $user->setPassword($password);

        $user->setEmail('at@at.at');

        $user->setIsActive(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
            
        $userRepository = $this->entityManager
            ->getRepository('AppBundle:User')
        ;

        $user = $userRepository->getUserByEmail('at@at.at');

        $actual = $user->getUsername();

        $this->assertEquals($expected, $actual);
    }

    public function testGetUserByEmailCaseInsensitive()
    {
        $expected = 'HatTrick';

        $user = new User();
        $user->setUsername('HatTrick');
        
        $password = $this->passwordEncoder->encodePassword($user, 'hathathat');
        $user->setPassword($password);

        $user->setEmail('At@at.at');

        $user->setIsActive(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
            
        $userRepository = $this->entityManager
            ->getRepository('AppBundle:User')
        ;

        $user = $userRepository->getUserByEmail('at@at.at');

        $actual = $user->getUsername();

        $this->assertEquals($expected, $actual);
    }
}
