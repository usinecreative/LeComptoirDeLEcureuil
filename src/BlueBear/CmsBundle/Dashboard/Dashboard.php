<?php

namespace BlueBear\CmsBundle\Dashboard;

use Exception;

class Dashboard
{
    protected $headingItems = [];

    protected $headingItemsCount = 4;

    protected $notificationsItems = [];

    public function addHeadingItem(DashboardItem $item)
    {
        if (count($this->headingItems) == $this->headingItemsCount) {
            throw new Exception('Only 4 heading items are allowed for this dashboard');
        }
        $this->headingItems[] = $item;
    }

    /**
     * @return array
     */
    public function getHeadingItems()
    {
        return $this->headingItems;
    }
}
