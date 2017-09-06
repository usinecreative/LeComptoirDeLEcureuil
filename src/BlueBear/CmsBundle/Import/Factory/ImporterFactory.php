<?php

namespace BlueBear\CmsBundle\Import\Factory;

use BlueBear\CmsBundle\Entity\Import;
use BlueBear\CmsBundle\Import\ImporterInterface;
use Exception;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ImporterFactory
{
    use ContainerAwareTrait;

    /**
     * @param $importType
     *
     * @return ImporterInterface
     *
     * @throws Exception
     */
    public function create($importType)
    {
        if ($importType == Import::IMPORT_TYPE_WORDPRESS) {
            $importer = $this
                ->container
                ->get('bluebear.cms.import.wordpress_importer');
        } else {
            throw new Exception(sprintf('Invalid import type "%s"', $importType));
        }

        return $importer;
    }
}
