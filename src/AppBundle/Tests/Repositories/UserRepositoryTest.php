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

    public function testGetUserNoResultException()
    {
        $expected = null;

        $userRepository = $this->entityManager
            ->getRepository('AppBundle:User')
        ;

        $actual = $userRepository->getUser('username');

        $this->assertEquals($expected, $actual);
    }

    public function testGetUser()
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

        $actual = $userRepository->getUser('HatTrick')->getUsername();

        $this->assertEquals($expected, $actual);
    }

    public function testGetUserCaseInsensitive()
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

        $actual = $userRepository->getUser('hattrick')->getUsername();

        $this->assertEquals($expected, $actual);
    }
}
