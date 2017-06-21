<?php

namespace JK\ColonelSmoker\Provider;

use JK\ColonelSmoker\Url\Url;
use JK\ColonelSmoker\Url\UrlCollection;

class SymfonyRoutingProvider implements ProviderInterface
{
    public function provide(): UrlCollection
    {
        $collection = new UrlCollection();
        $collection->add(new Url('http://127.0.0.1:8000/app_dev.php/'));
    
        return $collection;
    }
}
