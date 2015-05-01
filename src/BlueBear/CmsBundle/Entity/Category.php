<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Nameable;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="publication_status", type="smallint")
     */
    protected $publicationStatus;

    /**
     * @ORM\OneToMany(targetEntity="BlueBear\CmsBundle\Entity\Article", mappedBy="category")
     */
    protected $articles;

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
}