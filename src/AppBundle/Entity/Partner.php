<?php

namespace AppBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Partner
 *
 * @ORM\Table(name="lecomptoir_partner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartnerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Partner
{
    use Id, Timestampable;

    /**
     * Partner name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @var string
     */
    protected $name;

    /**
     * Partner description
     *
     * @ORM\Column(name="description", type="text")
     * @var string
     */
    protected $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     * @var string
     */
    protected $slug;

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string $slug
     * @return Partner
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
}
