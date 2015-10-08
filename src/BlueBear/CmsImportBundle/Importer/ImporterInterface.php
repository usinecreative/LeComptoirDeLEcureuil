<?php

namespace BlueBear\CmsImportBundle\Importer;


use BlueBear\CmsImportBundle\Entity\Import;

interface ImporterInterface
{
    public function import(Import $import);
}
