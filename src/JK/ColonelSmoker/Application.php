<?php

namespace JK\ColonelSmoker;

use JK\ColonelSmoker\Handler\HandlerInterface;
use JK\ColonelSmoker\Provider\ProviderInterface;
use JK\ColonelSmoker\Url\UrlCollection;

class Application
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers = [];
    
    protected $handlers = [];
    
    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }
    
    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }
    
    public function run()
    {
        // collect urls
        $collection = $this->collectUrls();
        
        
    }
    
    protected function collectUrls()
    {
        $mainCollection = new UrlCollection();
    
        foreach ($this->providers as $provider) {
            $collection = $provider->provide();
    
            foreach ($collection->getItems() as $url) {
                $mainCollection->add($url);
            }
        }
    
        return $mainCollection;
    }
}
