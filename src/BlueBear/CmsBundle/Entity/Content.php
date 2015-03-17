<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Descriptionable;
use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Typeable;
use BlueBear\CoreBundle\Entity\Behaviors\Nameable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="cms_content")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\ContentRepository")
 */
class Content
{
    use Id, Nameable, Descriptionable, Typeable;
}