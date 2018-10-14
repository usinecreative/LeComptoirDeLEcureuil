<?php

namespace App\JK\SmokerBundle\Url\Requirements\Registry;

use App\JK\SmokerBundle\Url\Requirements\Provider\RequirementsProviderInterface;

class RequirementsProviderRegistry
{
    protected $registry = [];

    public function add(string $name, RequirementsProviderInterface $provider): void
    {
        $this->registry[$name] = $provider;
    }

    public function get(string $name): RequirementsProviderInterface
    {

    }

    public function has(string $name): bool
    {

    }

    /**
     * @return RequirementsProviderInterface[]
     */
    public function all(): array
    {
        return $this->registry;
    }
}
