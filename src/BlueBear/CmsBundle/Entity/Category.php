<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Nameable;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Category
 *
 * Category are articles parents
 *
 * @ORM\Table(name="cms_category")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    use Id, Nameable, Timestampable;

    const PUBLICATION_NOT_PUBLISHED = 0;
    const PUBLICATION_STATUS_PUBLISHED = 1;

    /**
     * Set if current category is default category
     *
     * @var bool
     * @ORM\Column(name="is_default", type="boolean")
     */
    protected $isDefault = false;

    /**
     * @var int
     * @ORM\Column(name="publication_status", type="smallint", nullable=true)
     */
    protected $publicationStatus;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="BlueBear\CmsBundle\Entity\Article", mappedBy="category")
     */
    protected $articles;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    protected $slug;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @return boolean
     */
    public function isIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * @param boolean $isDefault
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    public function addArticle(Article $article)
    {
        $this->articles->add($article);
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
}
