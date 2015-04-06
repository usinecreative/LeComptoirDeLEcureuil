<?php

namespace BlueBear\CmsBundle\Cms;

use Exception;

class ContentBehavior
{
    protected $name;

    protected $class;

    protected $fields = [];

    public function hydrateFromConfiguration($name, array $contentBehaviorConfiguration)
    {
        if (!class_exists($contentBehaviorConfiguration['class'])) {
            throw new Exception("Invalid class {$contentBehaviorConfiguration['class']} for behavior \"{$name}\"");
        }
        $this->name = $name;
        $this->class = $contentBehaviorConfiguration['class'];
        $this->fields = $contentBehaviorConfiguration['fields'];

    }

    public function getName()
    {
        return $this->name;
    }

    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}