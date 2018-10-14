<?php

namespace App\JK\SmokerBundle\Url\Response\Handler;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

interface ResponseHandlerInterface
{
    public function supports(string $routeName): bool;

    public function handle(Crawler $crawler, Client $client);
}
