<?php

namespace BlueBear\CmsImportBundle\Service;


use BlueBear\CmsImportBundle\Entity\Import;

interface ImporterInterface
{
    public function import(Import $import);
}
