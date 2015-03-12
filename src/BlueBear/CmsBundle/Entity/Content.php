<?php

namespace BlueBear\CmsBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Descriptionable;
use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Typeable;
use BlueBear\CoreBundle\Entity\Behaviors\Nameable;

class Content
{
    use Id, Nameable, Descriptionable, Typeable;
}