<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        // title should be present
        $this->assertContains('<h1 class="site-title">Le Comptoir de l\'Ecureuil</h1>', $client->getResponse()->getContent());

        // menu should contains elements
        $this->assertEquals(1, $crawler->filter('li a:contains("Accueil")')->count());

        // categories
        $this->assertEquals(1, $crawler->filter('li a:contains("Littérature")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Manga/BD")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Rencontres")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Sorties")')->count());

        // partners
        $this->assertEquals(1, $crawler->filter('li a:contains("Editions Mnémos")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Editions Du Chat Noir")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Editions ActuSF")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Editions de la Bourdonnaye")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Intergalactiques De Lyon")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Trollune")')->count());
        $this->assertEquals(1, $crawler->filter('li a:contains("Esprit livre")')->count());

        // who am i
        $this->assertEquals(1, $crawler->filter('li a:contains("Qui-suis-je")')->count());
        $this->assertEquals(2, $crawler->filter('li a:contains("Contact")')->count());
    }
}
