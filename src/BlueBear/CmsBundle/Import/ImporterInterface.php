<?php

namespace BlueBear\CmsBundle\Import;


use BlueBear\CmsBundle\Entity\Import;

interface ImporterInterface
{
    public function import(Import $import);
}
