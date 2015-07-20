<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use Doctrine\ORM\Mapping as ORM;

/**
 * Parameters
 *
 * @ORM\Table(name="cms_parameters")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\ParametersRepository")
 */
class Parameters
{
    use Id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(name="value", type="string", length=255)
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
