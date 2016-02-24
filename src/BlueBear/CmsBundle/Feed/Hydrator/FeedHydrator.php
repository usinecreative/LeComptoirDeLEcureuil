<?php

namespace BlueBear\CmsBundle\Feed\Hydrator;

use BlueBear\CmsBundle\Entity\Article;
use Eko\FeedBundle\Hydrator\HydratorInterface;
use Exception;
use Zend\Feed\Reader\Feed\FeedInterface;

class FeedHydrator implements HydratorInterface
{
    /**
     * Hydrates given entity from its name with Feed data retrieved from reader.
     *
     * @param FeedInterface $feed A Feed instance
     * @param string $entityName An entity name to populate with feed entries
     * @return array if entity does not implements ItemInterface
     * @throws Exception
     */
    public function hydrate(FeedInterface $feed, $entityName)
    {
        foreach ($feed as $item) {
            if (!$this->supportClass($item)) {
                $class = get_class($item);
                throw new Exception("Class {$class}");
            }
            die('lol');
        }
    }

    public function supportClass($item)
    {
        $supported = false;

        if ($item instanceof Article) {
            $supported = true;
        }
        return $supported;
    }
}
