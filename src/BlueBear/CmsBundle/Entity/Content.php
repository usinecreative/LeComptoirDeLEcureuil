<?php

namespace BlueBear\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Content
 *
 * @ORM\Table(name="cms_content")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\ContentRepository")
 */
class Content
{
    /**
     * Entity id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    protected $fields = [];
    
    /**
     * Entity type
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $type;

    protected $behaviors = [];
    
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
        $method = Container::underscore($method);

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
    
    /**
     * Return entity type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set entity type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
