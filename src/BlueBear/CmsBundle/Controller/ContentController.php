<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use BlueBear\CmsBundle\Entity\Content;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContentController extends Controller
{
    use ControllerTrait;

    /**
     * @Template()
     */
    public function listAction()
    {
        return [

        ];
    }

    /**
     * @Template()
     * @param $type
     * @param null $id
     * @return array
     */
    public function editAction($type, $id = null)
    {
        $this->forward404Unless($type, 'Content name not found');
        $content = $this->get('bluebear.cms.manager.content')->create($type);
        $content->setType($type);

        if ($id) {

        }
        $form = $this->createForm('content', $content);

        return [

        ];
    }
}