<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class MainControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Crawler
     */
    protected $crawler;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->crawler = $this
            ->client
            ->request('GET', '/');
    }

    public function testHtml()
    {
        // title should be present
        $this->assertContains(
            '<h1 class="site-title">Le Comptoir de l\'Ecureuil</h1>',
            $this
                ->client
                ->getResponse()
                ->getContent()
        );
        $this->assertFalse($this->client->getResponse()->isNotFound());
    }

    public function testMenu()
    {
        // menu should contains elements
        $this->assertEquals(1, $this->crawler->filter('li a:contains("Accueil")')->count());

        // categories
        $this->assertEquals(1, $this->crawler->filter('li a:contains("Littérature")')->count());
        $this->assertEquals(1, $this->crawler->filter('li a:contains("Manga/BD")')->count());
        $this->assertEquals(1, $this->crawler->filter('li a:contains("Rencontres")')->count());
        $this->assertEquals(1, $this->crawler->filter('li a:contains("Sorties")')->count());

        // partners
        $this->assertEquals(1, $this->crawler->filter('.nav.navbar-nav li a:contains("Editions Mnémos")')->count());
        $this->assertEquals(1, $this->crawler->filter('.nav.navbar-nav li a:contains("Editions Du Chat Noir")')->count());
        $this->assertEquals(1, $this->crawler->filter('.nav.navbar-nav li a:contains("Editions ActuSF")')->count());
        $this->assertEquals(1, $this->crawler->filter('.nav.navbar-nav li a:contains("Intergalactiques De Lyon")')->count());
        $this->assertEquals(1, $this->crawler->filter('.nav.navbar-nav li a:contains("Trollune")')->count());
        $this->assertEquals(1, $this->crawler->filter('.nav.navbar-nav li a:contains("L\'Esprit livre")')->count());
        $this->assertEquals(1, $this->crawler->filter('.nav.navbar-nav li a:contains("Editions Rivière Blanche")')->count());

        // who am i
        $this->assertEquals(1, $this->crawler->filter('li a:contains("Qui-suis-je")')->count());
        $this->assertEquals(2, $this->crawler->filter('li a:contains("Contact")')->count());
    }

    public function testAssets()
    {
        // app.css SHOULD be included in the page
        $this->assertContains(
            '<link rel="stylesheet" href="/css/app.css">',
            $this
                ->client
                ->getResponse()
                ->getContent()
        );
        // assert commit file exists and contains no space
        $this->assertFileExists('web/css/app.css');
        $this->assertNotContains('} ', file_get_contents('web/css/app.css'));
        $this->assertNotContains(' {', file_get_contents('web/css/app.css'));
    }
}
