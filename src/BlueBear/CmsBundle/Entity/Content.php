<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Descriptionable;
use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Typeable;
use BlueBear\BaseBundle\Entity\Behaviors\Nameable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="cms_content")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\ContentRepository")
 */
class Content
{
    use Id, Nameable, Descriptionable, Typeable;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    protected $fields = [];

    protected $behaviors = [];

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function addField($name, $value)
    {
        $this->fields[$name] = $value;
    }

    /**
     * @return array
     */
    public function getBehaviors()
    {
        return $this->behaviors;
    }

    /**
     * @param array $behaviors
     */
    public function setBehaviors($behaviors)
    {
        $this->behaviors = $behaviors;
    }
}