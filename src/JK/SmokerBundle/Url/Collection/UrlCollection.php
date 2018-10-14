<?php

namespace App\JK\SmokerBundle\Url\Collection;

use App\JK\SmokerBundle\Url\Url;

class UrlCollection
{
    protected $urls = [];

    public function add(Url $url): void
    {
        $this->urls[] = $url;
    }

    /**
     * @return Url[]
     */
    public function all(): array
    {
        return $this->urls;
    }

    public function count(): int
    {
        return count($this->urls);
    }
}
