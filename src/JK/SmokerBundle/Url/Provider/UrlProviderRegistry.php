<?php

namespace App\JK\SmokerBundle\Url\Provider;

class UrlProviderRegistry
{
    protected $registry = [];

    public function add(string $name, UrlProviderInterface $provider): void
    {
        $this->registry[$name] = $provider;
    }

    public function get(string $name): UrlProviderInterface
    {

    }

    public function has(string $name): bool
    {

    }

    /**
     * @return UrlProviderInterface[]
     */
    public function all(): array
    {
        return $this->registry;
    }
}
