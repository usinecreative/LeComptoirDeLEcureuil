<?php

namespace App\Bridge\LAG\SmokerBundle\Url\Provider;

use LAG\SmokerBundle\Url\Collection\UrlCollection;
use LAG\SmokerBundle\Url\Provider\UrlProviderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmsUrlProvider implements UrlProviderInterface
{
    public function getCollection(array $options = []): UrlCollection
    {
        return new UrlCollection();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // TODO: Implement configureOptions() method.
    }

    public function getName(): string
    {
        return 'cms_url_provider';
    }

    public function getErrorMessages(): array
    {
        return [];
    }

    public function getIgnoredMessages(): array
    {
        return [];
    }

    /**
     * Return the route matching the given path.
     *
     * @param string $path
     *
     * @return string
     */
    public function match(string $path): string
    {
        // TODO: Implement match() method.
    }

    /**
     * Return true if the given path is supported by the provider.
     *
     * @param string $path
     *
     * @return bool
     */
    public function supports(string $path): bool
    {
        return false;
    }
}
