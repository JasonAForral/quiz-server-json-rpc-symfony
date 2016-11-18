<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\{
    AbstractFixture,
    OrderedFixtureInterface
};
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class LoadUserData
    extends AbstractFixture
    implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');

        $users = [
            [
                'username' => 'hattrick',
                'password' => 'hathathat',
                'email' => 'email',
            ],
            [
                'username' => 'AtomicNumbers',
                'password' => 'atomicnumbers',
                'email' => 'email2',
            ],
        ];

        foreach($users as $userData) {
            $user = new User();

            $username = $userData['username'];
            $user->setUsername($username);

            $password = $encoder->encodePassword($user, $userData['password']);
            $user->setPassword($password);

            $email = $userData['email'];
            $user->setEmail($email);

            $user->setIsActive(true);

            $manager->persist($user);
            $manager->flush();

            $reference = 'user-' . $userData['username'];

            $this->addReference($reference, $user);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}