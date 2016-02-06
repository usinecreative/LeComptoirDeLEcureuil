<?php

namespace BlueBear\CmsBundle\Widget;


interface WidgetInterface
{
    /**
     * Return the widget name
     *
     * @return string
     */
    public function getName();

    /**
     * Return the widget html render
     *
     * @param array $options
     * @return string
     */
    public function render(array $options = []);
}
