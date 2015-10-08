<?php

namespace BlueBear\CmsImportBundle\Factory;


use BlueBear\CmsImportBundle\Entity\Import;
use Exception;

class ImporterFactory
{
    public function create(Import $import)
    {
        // TODO make dynamic importer
        if ($import->getType() == Import::IMPORT_TYPE_WORDPRESS) {

        } else {
            throw new Exception(sprintf('Invalid import type "%s"', $import->getType()));
        }
    }
}
