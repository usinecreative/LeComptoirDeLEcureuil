<?php

namespace BlueBear\MediaBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Nameable;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="cms_media")
 * @ORM\Entity(repositoryClass="BlueBear\MediaBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Media
{
    use Id, Nameable, Timestampable;

    /**
     * @ORM\Column(name="filepath", type="string")
     */
    protected $filepath;

    /**
     * @ORM\Column(name="size", type="integer")
     */
    protected $size;

    /**
     * @ORM\Column(name="type", type="string")
     */
    protected $type;

    /**
     * @return mixed
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @param mixed $filepath
     */
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
