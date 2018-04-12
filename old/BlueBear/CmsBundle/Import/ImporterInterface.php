<?php

namespace BlueBear\CmsBundle\Import;

use App\Entity\Import;

interface ImporterInterface
{
    public function import(Import $import);
}
