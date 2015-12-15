<?php

namespace LeComptoirDeLEcureuil\FrontBundle\DataFixtures\ORM;

use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Entity\Category;
use BlueBear\CmsUserBundle\Entity\User;
use DateTime;
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

    protected function loadCategory($name, $slug, $isDisplayedInHomepage = false)
    {
        $category = new Category();
        $category->setName($name);
        $category->setSlug($slug);
        $category->setDisplayInHomepage($isDisplayedInHomepage);
        $this->manager->persist($category);

        return $category;
    }

    protected function loadArticle($title, $content, $slug, Category $category, User $user)
    {
        $article = new Article();
        $article->setTitle($title);
        $article->setContent($content);
        $article->setSlug($slug);
        $article->setAuthor($user);
        $article->setCanonical('test');
        $article->setCategory($category);
        $article->setPublicationStatus(Article::PUBLICATION_STATUS_PUBLISHED);
        $article->setPublicationDate(new DateTime());
        $article->setIsCommentable(true);
        $this->manager->persist($article);

        return $article;
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
