<?php

namespace BlueBear\CmsBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category
 *
 * Category are articles parents
 *
 * @ORM\Table(name="cms_article")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    const PUBLICATION_STATUS_DRAFT = 0;
    const PUBLICATION_STATUS_VALIDATION = 1;
    const PUBLICATION_STATUS_PUBLISHED = 2;
    
    /**
     * Entity id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * Article title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @var string
     */
    protected $title;

    /**
     * Article canonical url
     *
     * @ORM\Column(name="canonical", type="string", nullable=true)
     * @var string
     */
    protected $canonical;

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
     * Article content
     *
     * @ORM\Column(name="content", type="text")
     * @var string
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="BlueBear\CmsBundle\Entity\Category", inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     * @var Category
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="BlueBear\CmsBundle\Entity\User", inversedBy="articles")
     * @var User
     */
    protected $author;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="BlueBear\CmsBundle\Entity\Comment", mappedBy="article")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $comments;

    /**
     * @ORM\Column(name="is_commentable", type="boolean")
     */
    protected $isCommentable = true;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @ORM\Column(name="thumbnail_name", type="string", nullable=true)
     */
    protected $thumbnailName;

    /**
     * @Assert\File(maxSize="10M")
     */
    protected $thumbnailFile;

    /**
     * @ORM\ManyToMany(targetEntity="BlueBear\CmsBundle\Entity\Tag", mappedBy="articles")
     */
    protected $tags;
    
    /**
     * @var DateTime
     *
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

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
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
     * @Assert\Callback()
     *
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {

        //var_dump($context->getRoot());
        //var_dump($context->getPropertyPath());
        //var_dump($this->getPublicationStatus());

        if ($this->getPublicationStatus() == self::PUBLICATION_STATUS_PUBLISHED
            && !($this->getPublicationDate() instanceof DateTime)) {
            // if the article is published, it should have a publication date
            //$context->addViolation('cms.article.violations.publication_date');
            // TODO fix article validation
            $this->publicationDate = new DateTime();
        }
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @param string $canonical
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    }

    /**
     * @return mixed
     */
    public function getPublicationStatus()
    {
        return $this->publicationStatus;
    }

    /**
     * @param mixed $publicationStatus
     */
    public function setPublicationStatus($publicationStatus)
    {
        $this->publicationStatus = $publicationStatus;
    }

    /**
     * @return mixed
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param mixed $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

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
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getIsCommentable()
    {
        return $this->isCommentable;
    }

    /**
     * @return bool
     */
    public function isCommentable()
    {
        return (bool) $this->isCommentable;
    }

    /**
     * @param mixed $isCommentable
     */
    public function setIsCommentable($isCommentable)
    {
        $this->isCommentable = $isCommentable;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
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
     * @return array
     */
    public function getUrlParameters()
    {
        $year = date('Y');
        $month = date('m');
        $slug = $this->slug;

        if (null !== $this->publicationDate) {
            $year = $this->publicationDate->format('Y');
            $month = $this->publicationDate->format('m');
        }

        if (null === $slug) {
            $slug = '__TOKEN__';
        }

        return [
            'year' => $year,
            'month' => $month,
            'slug' => $slug
        ];
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCategories()
    {
        $category = $this->category;
        $categories = [
            $category
        ];

        while ($category->getParent()) {
            $categories[] = $category->getParent();
            $category = $category->getParent();
        }
        return $categories;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
        $tag->addArticle($this);
    }

    /**
     * @param Tag $tag
     * @return bool
     */
    public function hasTag(Tag $tag)
    {
        return $this
            ->tags
            ->contains($tag);
    }

    /**
     * @param mixed $tags
     * @return Article
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
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

        if ($thumbnailFile) {
            $this->updatedAt = new DateTime();
        }
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
}
