<?php

namespace AppBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Partner
 *
 * @ORM\Table(name="lecomptoir_partner", indexes={@ORM\Index(name="slug_idx", columns={"slug"})}))
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartnerRepository")
 *
 * @UniqueEntity(fields={"name", "slug"})
 *
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
     * @var string
     *
     * @ORM\Column(name="baseline", type="string", length=255, nullable=true)
     */
    protected $baseline;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="text", nullable=true)
     */
    protected $website;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="text", nullable=true)
     */
    protected $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="text", nullable=true)
     */
    protected $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="text", nullable=true)
     */
    protected $instagram;

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
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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

    /**
     * @return string
     */
    public function getBaseline()
    {
        return $this->baseline;
    }

    /**
     * @param string $baseline
     * @return $this
     */
    public function setBaseline($baseline)
    {
        $this->baseline = $baseline;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     * @return $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param string $instagram
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
    }
}
