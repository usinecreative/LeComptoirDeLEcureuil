<?php

namespace BlueBear\CmsBundle\Widget\Factory;

class WidgetFactory
{
    /**
     * @var array
     */
    protected $allowedWidgets;

    public function __construct($allowedWidgets = [])
    {
        $this->allowedWidgets = $allowedWidgets;
    }
}
