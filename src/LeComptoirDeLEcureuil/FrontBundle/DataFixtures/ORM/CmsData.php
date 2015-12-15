<?php

namespace LeComptoirDeLEcureuil\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CmsData extends FixturesBase implements FixtureInterface
{


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadUsers();
        $this->loadCategories();
        $this->manager->flush();
    }

    protected function loadUsers()
    {
        $this->loadUser('Salveena', 'admin', $this->container->getParameter('default_mail'));
    }

    protected function loadCategories()
    {
        $this->loadCategory('Littérature', 'litterature', true);
        $this->loadCategory('Manga/BD', 'manga-bd', true);
        $this->loadCategory('Sorties', 'sorties', true);
        $this->loadCategory('Rencontres', 'rencontres', true);
    }
}
