<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use BlueBear\BaseBundle\Entity\Behaviors\Id;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * Category are articles parents
 *
 * @ORM\Table(name="cms_comment")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    use Id, Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity="BlueBear\CmsBundle\Entity\Article", inversedBy="comments")
     */
    protected $article;

    /**
     * @ORM\Column(name="author_name", type="string", length=255)
     */
    protected $authorName;

    /**
     * @ORM\Column(name="author_email", type="string", length=255)
     */
    protected $authorEmail;

    /**
     * @ORM\Column(name="author_url", type="string", length=255)
     */
    protected $authorUrl;

    /**
     * @ORM\Column(name="author_ip", type="string", length=255)
     */
    protected $authorIp;

    /**
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @ORM\Column(name="is_approved", type="boolean")
     */
    protected $isApproved = false;

    /**
     * @ORM\Column(name="metadata", type="array")
     */
    protected $metadata = [];

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param mixed $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return mixed
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * @param mixed $authorEmail
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     * @return mixed
     */
    public function getAuthorIp()
    {
        return $this->authorIp;
    }

    /**
     * @param mixed $authorIp
     */
    public function setAuthorIp($authorIp)
    {
        $this->authorIp = $authorIp;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getIsApproved()
    {
        return $this->isApproved;
    }

    /**
     * @param mixed $isApproved
     */
    public function setIsApproved($isApproved)
    {
        $this->isApproved = $isApproved;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    public function addMetadata($key, $value)
    {
        $this->metadata[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * @param mixed $authorUrl
     */
    public function setAuthorUrl($authorUrl)
    {
        $this->authorUrl = $authorUrl;
    }
}