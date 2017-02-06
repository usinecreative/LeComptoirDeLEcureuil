<?php

namespace BlueBear\CmsBundle\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

/**
 * Define the behavior of having an array of string tag.
 */
trait Taggable
{
    /**
     * Tags array.
     *
     * @var string[]
     * @ORM\Column(name="tags", type="array")
     */
    protected $tags = [];

    /**
     * Define tags.
     *
     * @param string[] $tags
     *
     * @return Taggable
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Return tags.
     *
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }
}
