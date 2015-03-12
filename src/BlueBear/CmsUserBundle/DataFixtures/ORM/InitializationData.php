<?php

namespace BlueBear\CmsUserBundle\DataFixtures\ORM;

use BlueBear\CmsUserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class InitializationData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // create users
        $manager->persist($this->createUser('salveena', 'admin'));
        $manager->flush();
    }

    /**
     * Create user (with default email if not provided)
     *
     * @param $userName
     * @param $plainPassword
     * @param null $email
     * @return User
     */
    protected function createUser($userName, $plainPassword, $email = null)
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setPlainPassword($plainPassword);
        $user->setEnabled(true);

        if ($email) {
            $user->setEmail($email);
        } else {
            $user->setEmail($userName . '@clever-age.com');
        }
        return $user;
    }
}