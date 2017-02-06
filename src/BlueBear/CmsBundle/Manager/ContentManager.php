<?php

namespace BlueBear\CmsBundle\Manager;

use BlueBear\BaseBundle\Behavior\ManagerTrait;
use BlueBear\CmsBundle\Entity\Content;
use Doctrine\ORM\EntityRepository;
use Exception;

class ContentManager
{
    use ManagerTrait;

    /**
     * Create content from configured type.
     *
     * @param $type
     *
     * @return Content
     *
     * @throws Exception
     */
    public function create($type)
    {
        $contentType = $this
            ->getContainer()
            ->get('bluebear.cms.content_type_factory')
            ->getContentType($type);
        $content = new Content();
        $content->setType($type);
        $fields = $contentType->getFields();

        foreach ($fields as $fieldName => $fieldConfiguration) {
            $content->addField($fieldName, null);
        }

        return $content;
    }

    public function save(Content $content)
    {
        $this->getEntityManager()->persist($content);
        $this->getEntityManager()->flush($content);
    }

    public function findByTypeQueryBuilder($type)
    {
        return $this
            ->getRepository()
            ->createQueryBuilder('content')
            ->where('content.type = :type')
            ->setParameter('type', $type);
    }

    /**
     * Return current manager repository.
     *
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getEntityManager()->getRepository('BlueBearCmsBundle:Content');
    }
}
