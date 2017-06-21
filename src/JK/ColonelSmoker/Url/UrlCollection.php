<?php

namespace JK\ColonelSmoker\Url;

class UrlCollection
{
    protected $items = [];
    
    public function add(Url $url)
    {
        $this->items[] = $url;
    }
    
    public function getItems()
    {
        return $this->items;
    }
}
