<?php

namespace BlueBear\CmsBundle\Cms;

class ContentType 
{
    protected $name;

    protected $fields;

    protected $behaviors = [];

    protected $parent = null;

    public function hydrateFromConfiguration($name, array $typeConfiguration)
    {
        $this->name = $name;

        if (array_key_exists('fields', $typeConfiguration)) {
            $this->fields = $typeConfiguration['fields'];
        } else {
            throw new \Exception("Content type \"{$this->name}\" should have fields");
        }
        if (array_key_exists('behaviors', $typeConfiguration)) {
            foreach ($typeConfiguration['behaviors'] as $behaviorName => $behavior) {
                var_dump($behaviorName);
                die;
            }
        }
    }

    /**
     * @return array
     */
    public function getBehaviors()
    {
        return $this->behaviors;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}