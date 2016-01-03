<?php

namespace BlueBear\CmsBundle\Dashboard;


class DashboardItem
{
    /**
     * Font awesome icons
     *
     * @var string
     */
    protected $icon;

    /**
     * Items counts
     *
     * @var int
     */
    protected $count;

    /**
     * Text for the link
     *
     * @var string
     */
    protected $text;

    /**
     * Url for the link
     *
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $linkText;

    /**
     * @var string
     */
    protected $panelClass;

    /**
     * DashboardCategory constructor.
     *
     * @param int $count
     * @param string $text
     * @param string|null $url
     * @param string|null $icon
     * @param string $linkText
     * @param string $panelClass
     */
    public function __construct(
        $count,
        $text,
        $url = null,
        $icon = null,
        $panelClass = 'primary',
        $linkText = 'lag.cms.dashboard_heading_text'
    ) {
        $this->icon = $icon;
        $this->count  = $count;
        $this->text = $text;
        $this->url = $url;
        $this->linkText = $linkText;
        $this->panelClass = $panelClass;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getLinkText()
    {
        return $this->linkText;
    }

    /**
     * @return string
     */
    public function getPanelClass()
    {
        return $this->panelClass;
    }
}
