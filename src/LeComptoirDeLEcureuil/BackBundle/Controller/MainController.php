<?php

namespace LeComptoirDeLEcureuil\BackBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use BlueBear\CmsBundle\Factory\ContentTypeFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    use ControllerTrait;

    /**
     * @Template()
     */
    public function indexAction()
    {
        $contentTypes = $this->getContentTypeFactory()->getContentTypes();
        $userAdmin = $this->get('bluebear.admin.factory')->getAdmin('user');

        return [
            'contentTypes' => $contentTypes,
            'addUserRoute' => $userAdmin->generateRouteName('create'),
            'listUserRoute' => $userAdmin->generateRouteName('list')
        ];
    }

    /**
     * @return ContentTypeFactory
     */
    protected function getContentTypeFactory()
    {
        return $this->getContainer()->get('bluebear.cms.content_type_factory');
    }
}