<?php

namespace App\JK\SmokerBundle\Url\Requirements\Provider;

interface RequirementsProviderInterface
{
    public function supports(string $routeName): bool;

    public function getRequirements(string $routeName): \Traversable;
}
