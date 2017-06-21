<?php

namespace JK\ColonelSmoker\Provider;

use JK\ColonelSmoker\Url\UrlCollection;

interface ProviderInterface
{
    public function provide(): UrlCollection;
}
