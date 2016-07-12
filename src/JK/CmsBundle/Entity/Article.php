<?php

namespace JK\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
    use Timestampable;

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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * Article canonical url
     *
     * @var string
     *
     * @ORM\Column(name="canonical", type="string")
     */
    protected $canonical;

    /**
     * Article current status for publication (draft, published...)
     *
     * @var int
     *
     * @ORM\Column(name="publication_status", type="smallint")
     */
    protected $publicationStatus;

    /**
     * Article publication date
     *
     * @var DateTime
     *
     * @ORM\Column(name="publication_date", type="datetime")
     */
    protected $publicationDate;

    /**
     * Article content
     *
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * Article categories
     *
     * @var Category
     *
     * @ORM\ManyToMany(targetEntity="BlueBear\CmsBundle\Entity\Category", inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $category;

    /**
     * Article author
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="BlueBear\CmsBundle\Entity\User", inversedBy="articles")
     */
    protected $author;

    /**
     * Article comments, posted by the readers
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BlueBear\CmsBundle\Entity\Comment", mappedBy="article")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $comments;

    /**
     * If true, users can add comments to the this article.
     *
     * @var boolean
     *
     * @ORM\Column(name="is_commentable", type="boolean")
     */
    protected $isCommentable = false;

    /**
     * Article slug
     *
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="BlueBear\MediaBundle\Entity\Media", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $thumbnail;

    /**
     * @ORM\ManyToMany(targetEntity="BlueBear\CmsBundle\Entity\Tag", mappedBy="articles")
     */
    protected $tags;

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
        // TODO move in configuration
        return [
            'year' => $this->publicationDate->format('Y'),
            'month' => $this->publicationDate->format('m'),
            'slug' => $this->slug
        ];
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
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
}
