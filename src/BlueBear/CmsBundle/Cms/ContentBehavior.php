<?php

namespace BlueBear\CmsBundle\Cms;

class ContentBehavior 
{
    protected $name;

    protected $class;

    public function hydrateFromConfiguration($name, array $contentBehaviorConfiguration)
    {
        $this->name = $name;
        $this->class = $contentBehaviorConfiguration['class'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getClass()
    {
        return $this->class;
    }
}