<?php

namespace BlueBear\CmsBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    const PUBLICATION_NOT_PUBLISHED = 0;
    const PUBLICATION_STATUS_PUBLISHED = 1;
    
    /**
     * Entity id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * Entity name
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

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
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/png", "image/jpeg", "application/octet-stream"}
     * )
     */
    protected $thumbnailFile;

    /**
     * Entity description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    
    /**
     * @var DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;
    
    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;
    
    /**
     * @ORM\PrePersist()
     * @return $this
     */
    public function setCreatedAt()
    {
        if (!$this->createdAt) {
            $this->createdAt = new DateTime();
        }
    }
    
    /**
     * Return entity name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set entity name
     *
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

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

        // Only change the updated af if the file is really uploaded to avoid database updates.
        // This is needed when the file should be set when loading the entity.
        if ($this->thumbnailFile instanceof UploadedFile) {
            $this->updatedAt = new DateTime('now');
        }
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
        
    /**
     * Created at cannot be set. But in some case (like imports...), it is required to set created at. Use this method
     * in this case
     *
     * @param DateTime $createdAt
     */
    public function forceCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @param null $value
     * @return $this
     */
    public function setUpdatedAt($value = null)
    {
        if ($value instanceof DateTime) {
            $this->updatedAt = $value;
        } else {
            $this->updatedAt = new DateTime();
        }
        return $this;
    }
    
    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
