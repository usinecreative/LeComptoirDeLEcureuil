<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Behavior\StringUtilsTrait;
use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Typeable;
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
    use Id, Typeable, StringUtilsTrait;

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

    public function __call($method, $parameters = [])
    {
        $value = null;
        $method = $this->underscore($method);

        if (array_key_exists($method, $this->fields)) {
            $value = $this->fields[$method];
        }
        return $value;
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new Exception("Invalid field name \"{$name}\".");
        }
        return $this->fields[$name];
    }

    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new Exception("Invalid field name \"{$name}\".");
        }
        $this->fields[$name] = $value;
    }
}