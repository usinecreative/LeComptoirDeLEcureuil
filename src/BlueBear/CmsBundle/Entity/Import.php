<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Nameable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * Category are articles parents
 *
 * @ORM\Table(name="cms_article")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\ImportRepository")
 */
class Import
{
    use Id, Nameable;
}
