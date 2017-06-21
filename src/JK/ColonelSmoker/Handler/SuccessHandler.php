<?php

namespace JK\ColonelSmoker\Handler;

use GuzzleHttp\Client;
use JK\ColonelSmoker\Url\Url;

class SuccessHandler implements HandlerInterface
{
    protected $client;
    
    public function __construct()
    {
        $this->client = new Client();
    }
    
    public function handle(Url $url)
    {
        
    }
}
