<?php

namespace BlueBear\CmsImportBundle\Factory;


use BlueBear\BaseBundle\Behavior\ContainerTrait;
use BlueBear\CmsImportBundle\Entity\Import;
use Exception;

class ImporterFactory
{
    use ContainerTrait;

    public function create($importType)
    {
        // TODO make dynamic importer
        if ($importType == Import::IMPORT_TYPE_WORDPRESS) {
            $importer = $this->container->get('bluebear.cms.import.wordpress_importer');
        } else {
            throw new Exception(sprintf('Invalid import type "%s"', $importType));
        }
        return $importer;
    }
}
