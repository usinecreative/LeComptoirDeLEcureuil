<?php

namespace JK\ColonelSmoker\Url;

class Url
{
    protected $url;
    
    protected $options = [];
    
    public function __construct($url, array $options = [])
    {
        $this->url = $url;
        $this->options = $options;
    }
}
