<?php

namespace BlueBear\CmsBundle\Manager;

use BlueBear\BaseBundle\Behavior\ManagerTrait;
use BlueBear\CmsBundle\Entity\Content;
use Doctrine\ORM\EntityRepository;

class ContentManager
{
    use ManagerTrait;

    public function create($type)
    {
        $contentType = $this
            ->getContainer()
            ->get('bluebear.cms.content_type_factory')
            ->getContentType($type);
        $content = new Content();
        $content->setName('test');
        $content->setType($type);
        $fields = $contentType->getFields();

        foreach ($fields as $fieldName => $fieldConfiguration) {
            $content->addField($fieldName, $fieldConfiguration);
        }
        $this->save($content);

        var_dump($content->getFields());
        die;
    }

    /**
     * Return current manager repository
     *
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getEntityManager()->getRepository('BlueBearCmsBundle:Content');
    }
}