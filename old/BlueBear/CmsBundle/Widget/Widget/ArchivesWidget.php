<?php

namespace BlueBear\CmsBundle\Widget\Widget;

use BlueBear\CmsBundle\Widget\WidgetInterface;

class ArchivesWidget implements WidgetInterface
{
    /**
     * Return the widget name.
     *
     * @return string
     */
    public function getName()
    {
        return 'archives';
    }

    public function render(array $options = [])
    {
    }
}
