<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use BlueBear\CmsUserBundle\Entity\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
    use Id, Timestampable;

    const PUBLICATION_STATUS_DRAFT = 0;
    const PUBLICATION_STATUS_VALIDATION = 1;
    const PUBLICATION_STATUS_PUBLISHED = 2;

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
     * @ORM\Column(name="canonical", type="string")
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
     * @ORM\Column(name="publication_date", type="datetime")
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
     * @ORM\ManyToOne(targetEntity="BlueBear\CmsBundle\Entity\Category", inversedBy="articles")
     * @ORM\JoinColumn(nullable=true)
     * @var Category
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="BlueBear\CmsUserBundle\Entity\User", inversedBy="articles")
     * @var User
     */
    protected $author;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="BlueBear\CmsBundle\Entity\Comment", mappedBy="article")
     */
    protected $comments;

    /**
     * @ORM\Column(name="is_commentable", type="boolean")
     */
    protected $isCommentable;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
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

    public function isCommentable()
    {
        return (bool)$this->isCommentable;
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

    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
    }
}
