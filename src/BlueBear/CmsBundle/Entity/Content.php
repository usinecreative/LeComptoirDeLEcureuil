<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Descriptionable;
use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Typeable;
use BlueBear\BaseBundle\Entity\Behaviors\Nameable;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Content
 *
 * @ORM\Table(name="cms_content")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\ContentRepository")
 */
class Content
{
    use Id, Nameable, Typeable;

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

    public function __get($name)
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new Exception("Invalid field name \"{$name}\".");
        }
        return $this->fields[$name];
    }
}