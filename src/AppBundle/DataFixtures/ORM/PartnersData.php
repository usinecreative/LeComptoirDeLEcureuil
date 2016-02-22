<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Partner;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PartnersData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
//        $this->manager = $manager;
//
//        $this->save(
//            'Edition Mnemos',
//            '<p>Mnémos, éditeur d’imaginaire depuis 1996 et membre fondateur <strong><a href="http://www.mnemos.com/auteurs/les-indes-de-limaginaire/">des Indés de l’imaginaire</a></strong>.</p>
//<p><i>Les Éditions Mnémos défendent une littérature de l’imaginaire vivante et de qualité. Depuis 20 ans, plus de 200 titres ont été publiés. Notre politique éditoriale est basée autour de deux critères : la découverte de nouveaux talents et la mise en avant de la création française dans des genres habituellement dévolus aux auteurs anglo-saxons.<br>
//Nos publications se regroupent en livres grand format, en poche avec le label Hélios, en beaux livres avec notre label Ourobores.</i><i></i></p>
//<img alt="" src="http://www.mnemos.com/JOOMLA2/images/auteurs/fred%205%20site.gif" width="100" border="0"><img title="Nathalie Weil" alt="Nathalie Weil" src="http://www.mnemos.com/JOOMLA2/images/cartouche/nat.jpg" border="0">&nbsp;&nbsp;<img alt="" src="http://www.mnemos.com/JOOMLA2/images/cartouche/coralie%202-site.gif" width="100" border="0"><img alt="" src="http://www.mnemos.com/JOOMLA2/images/auteurs/st%C3%A9phanie%20site.gif" width="100" border="0">
//<p>Direction éditoriale :&nbsp;Frédéric WEIL<br>
//Administration – communication : Nathalie Weil</p>
//<p>Directeurs d’ouvrages : Stéphanie CHABERT -&nbsp;Coralie DAVID -&nbsp;Raphaël Granier de Cassagnac – Frédéric WEIL</p>
//<p>Graphistes : Franck ACHARD – Isabelle JOVANOVIC – Atelier Octobre Rouge</p>
//<p>Photographies : © Patrick Imbert, sauf pour Coralie et Stéphanie (voir son&nbsp;<a href="http://www.icicommeailleurs.org/" target="_blank">site</a>)<br>
//Photographie Coralie : ©&nbsp;Pouria Amir Ardalan</p>
//							</section>',
//            'Mnémos, éditeur d’imaginaire depuis 1996 et membre fondateur des Indés de l’imaginaire.'
//        );

        /*
        mnemos:
        name: Editions Mnemos
        description: <realText()>
    slug: editions-mnemos
#    chat-noir:
#    actu-sf:
#    bourdonnaye:
#    intergalactiques_lyon:
#    trollune:
#    esprit_livre:
*/
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param $name
     * @param $description
     * @param $baseline
     */
    protected function save($name, $description, $baseline)
    {
        $partner = $this
            ->container
            ->get('app_partner_repository')
            ->findOneBy([
                'name' => $name
            ]);

        if ($partner) {
            return;
        }
        $partner = new Partner();
        $partner
            ->setName($name)
            ->setDescription($description)
            ->setBaseline($baseline)
        ;
        $this
            ->manager
            ->persist($partner);
        $this
            ->manager
            ->flush();
    }
}
