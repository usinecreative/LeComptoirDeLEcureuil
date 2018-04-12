<?php

namespace App\Sitemap\Item;

class Item
{
    protected $location;

    protected $frequency;

    protected $priority;

    /**
     * @var null
     */
    protected $lastModification;

    public function __construct($location, $frequency = null, $priority = null, $lastModification = null)
    {
        $this->location = $location;
        $this->frequency = $frequency;
        $this->priority = $priority;
        $this->lastModification = $lastModification;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function getLastModification()
    {
        return $this->lastModification;
    }
}
