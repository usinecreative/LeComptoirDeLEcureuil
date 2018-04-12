<?php

namespace BlueBear\CmsBundle\Import\Factory;

use BlueBear\BaseBundle\Behavior\ContainerTrait;
use App\Entity\Import;
use BlueBear\CmsBundle\Import\ImporterInterface;
use Exception;

class ImporterFactory
{
    use ContainerTrait;

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
