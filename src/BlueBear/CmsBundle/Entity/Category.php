<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Descriptionable;
use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Nameable;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category
 *
 * Category are articles parents
 *
 * @ORM\Table(name="cms_category")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Vich\Uploadable()
 */
class Category
{
    use Id, Nameable, Timestampable, Descriptionable;

    const PUBLICATION_NOT_PUBLISHED = 0;
    const PUBLICATION_STATUS_PUBLISHED = 1;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="BlueBear\CmsBundle\Entity\Category", inversedBy="children")
     */
    protected $parent;

    /**
     * @var Category[]
     * @ORM\OneToMany(targetEntity="BlueBear\CmsBundle\Entity\Category", mappedBy="parent")
     */
    protected $children;

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

    /**
     * @var bool
     * @ORM\Column(name="display_in_homepage", type="boolean")
     */
    protected $displayInHomepage = false;

    /**
     * @ORM\Column(name="thumbnail_name", type="string", nullable=true)
     */
    protected $thumbnailName;

    /**
     * @Vich\UploadableField(mapping="category_media", fileNameProperty="thumbnailName")
     *
     * @Assert\File(maxSize="10M")
     */
    protected $thumbnailFile;

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
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

    /**
     * @param Article $article
     */
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

    /**
     * @return boolean
     */
    public function isDisplayInHomepage()
    {
        return $this->displayInHomepage;
    }

    /**
     * @param boolean $displayInHomepage
     */
    public function setDisplayInHomepage($displayInHomepage)
    {
        $this->displayInHomepage = $displayInHomepage;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Category[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Category[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getThumbnailName()
    {
        return $this->thumbnailName;
    }

    /**
     * @param mixed $thumbnailName
     */
    public function setThumbnailName($thumbnailName)
    {
        $this->thumbnailName = $thumbnailName;
    }

    /**
     * @return mixed
     */
    public function getThumbnailFile()
    {
        return $this->thumbnailFile;
    }

    /**
     * @param mixed $thumbnailFile
     */
    public function setThumbnailFile($thumbnailFile)
    {
        $this->thumbnailFile = $thumbnailFile;
    }
}
