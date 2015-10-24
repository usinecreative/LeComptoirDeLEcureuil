<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="cms_page")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Page
{
    use Id, Timestampable;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @ORM\Column(name="content", type="text", nullable=true)
     * @var string
     */
    protected $content;

    /**
     * Article title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @var string
     */
    protected $title;

    /**
     * Article current status for publication (draft, published...)
     *
     * @ORM\Column(name="publication_status", type="smallint")
     * @var int
     */
    protected $publicationStatus;

    /**
     * Article publication date
     *
     * @ORM\Column(name="publication_date", type="datetime", nullable=true)
     * @var DateTime
     */
    protected $publicationDate;

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getPublicationStatus()
    {
        return $this->publicationStatus;
    }

    /**
     * @param int $publicationStatus
     */
    public function setPublicationStatus($publicationStatus)
    {
        $this->publicationStatus = $publicationStatus;
    }

    /**
     * @return DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param DateTime $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

}
