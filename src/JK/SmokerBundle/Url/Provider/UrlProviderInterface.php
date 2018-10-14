<?php

namespace App\JK\SmokerBundle\Url\Provider;

use App\JK\SmokerBundle\Url\Collection\UrlCollection;

interface UrlProviderInterface
{
    public function getCollection(): UrlCollection;

    public function getErrorMessages(): array;

    public function getIgnoredMessages(): array;
}
