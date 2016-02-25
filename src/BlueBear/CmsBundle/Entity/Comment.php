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
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     * @return string
     */
    public function getAuthorIp()
    {
        return $this->authorIp;
    }

    /**
     * @param string $authorIp
     */
    public function setAuthorIp($authorIp)
    {
        $this->authorIp = $authorIp;
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
     * @return boolean
     */
    public function getIsApproved()
    {
        return $this->isApproved;
    }

    /**
     * @param boolean $isApproved
     */
    public function setIsApproved($isApproved)
    {
        $this->isApproved = $isApproved;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    public function addMetadata($key, $value)
    {
        $this->metadata[$key] = $value;
    }

    /**
     * @return string
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * @param string $authorUrl
     */
    public function setAuthorUrl($authorUrl)
    {
        $this->authorUrl = $authorUrl;
    }
}
