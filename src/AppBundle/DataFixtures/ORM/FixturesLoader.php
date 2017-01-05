<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

/**
 * Load yml fixtures from alice bundle.
 */
class FixturesLoader implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        Fixtures::load([
            __DIR__.'/Partners.yml',
            __DIR__.'/User.yml',
            __DIR__.'/Categories.yml',
            __DIR__.'/Articles.yml',
            __DIR__.'/Comments.yml',
            __DIR__.'/Tags.yml',
        ], $manager, [
            'locale' => 'fr_FR',
        ]);
    }
}
