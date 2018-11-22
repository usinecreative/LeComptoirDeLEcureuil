<?php

namespace App\Tests\Tests\Controller;

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
        $this->client->followRedirects(true);
        $this->crawler = $this
            ->client
            ->request('GET', '/')
        ;
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

    public function testMenuContainsHomepage()
    {
        $this->assertEquals(
            1,
            $this->crawler->filter('li a:contains("Accueil")')->count(),
            'The homepage link "Accueil" is missing'
        );
    }

    public function testMenuContainsCategories()
    {
        $this->assertEquals(
            1,
            $this->crawler->filter('li a.nav-link:contains("Littérature")')->count(),
            'The category link "Littérature" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('li a.nav-link:contains("Manga/BD")')->count(),
            'The category link "Manga/BD" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('li a.nav-link:contains("Rencontres")')->count(),
            'The category link "Rencontres" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('li a.nav-link:contains("Sorties")')->count(),
            'The category link "Sorties" is missing'
        );
    }

    public function testMenuContainsPartners()
    {
        $this->assertEquals(
            1,
            $this->crawler->filter('.nav.navbar-nav li a:contains("Editions Mnémos")')->count(),
            'The partner link "Editions Mnémos" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('.nav.navbar-nav li a:contains("Editions Du Chat Noir")')->count(),
            'The partner link "Editions Du Chat Noir" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('.nav.navbar-nav li a:contains("Editions ActuSF")')->count(),
            'The partner link "Editions ActuSF" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('.nav.navbar-nav li a:contains("Intergalactiques De Lyon")')->count(),
            'The partner link "Intergalactiques De Lyon" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('.nav.navbar-nav li a:contains("Trollune")')->count(),
            'The partner link "Trollune" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('.nav.navbar-nav li a:contains("L\'Esprit livre")')->count(),
            'The partner link "L\'Esprit livre" is missing'
        );
        $this->assertEquals(
            1,
            $this->crawler->filter('.nav.navbar-nav li a:contains("Editions Rivière Blanche")')->count(),
            'The partner link "Editions Rivière Blanche" is missing'
        );
    }

    public function testMenuContainsWhoAmI()
    {
        $this->assertEquals(1, $this->crawler->filter('li a:contains("Qui-suis-je")')->count());
    }

    public function testMenuContainsContact()
    {
        $this->assertEquals(2, $this->crawler->filter('li a:contains("Contact")')->count());
    }

    public function testAssets()
    {
        $manifest = json_decode(file_get_contents('public/build/manifest.json'), JSON_OBJECT_AS_ARRAY);

        // app.css SHOULD be included in the page
        $this->assertContains(
            '<link rel="stylesheet" href="'.$manifest['build/app.css'].'">',
            $this
                ->client
                ->getResponse()
                ->getContent()
        );

        // assert commit file exists and contains no space
        $this->assertFileExists('public'.$manifest['build/app.css']);
        $this->assertNotContains('} ', file_get_contents('public'.$manifest['build/app.css']));
        $this->assertNotContains(' {', file_get_contents('public'.$manifest['build/app.css']));
    }
}
