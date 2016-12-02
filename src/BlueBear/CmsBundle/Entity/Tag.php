<?php

namespace BlueBear\CmsBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tag
 *
 * Article tags
 *
 * @ORM\Table(name="cms_tag")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\TagRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Tag
{
    /**
     * Entity id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @ORM\ManyToMany(targetEntity="BlueBear\CmsBundle\Entity\Article", inversedBy="tags")
     * @ORM\JoinTable(name="cms_tag_article")
     */
    protected $articles;
    
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
     * Tag constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     * @return Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param mixed $articles
     * @return Tag
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    public function addArticle(Article $article)
    {
        $this->articles->add($article);
    }
    
    /**
     * Return entity id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set entity id
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAt()
    {
        if (!$this->createdAt) {
            $this->createdAt = new DateTime();
        }
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
