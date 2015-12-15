<?php

namespace LeComptoirDeLEcureuil\FrontBundle\DataFixtures\ORM;

use BlueBear\CmsBundle\Entity\Category;
use BlueBear\CmsUserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class FixturesBase implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * Create user (with default email if not provided)
     *
     * @param string $userName
     * @param string $plainPassword
     * @param string $email
     * @return User
     */
    protected function loadUser($userName, $plainPassword, $email)
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setPlainPassword($plainPassword);
        $user->setEnabled(true);
        $user->setEmail($email);
        $this->manager->persist($user);

        return $user;
    }

    protected function loadCategory($name, $slug, $isDisplayedInHomepage = false, $articles = [])
    {
        $category = new Category();
        $category->setName($name);
        $category->setSlug($slug);
        $category->setDisplayInHomepage($isDisplayedInHomepage);
        $this->manager->persist($category);

        return $category;
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
