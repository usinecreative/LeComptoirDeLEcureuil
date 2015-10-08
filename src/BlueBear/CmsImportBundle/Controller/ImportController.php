<?php

namespace BlueBear\CmsImportBundle\Controller;

use BlueBear\AdminBundle\Controller\GenericController;
use BlueBear\CmsImportBundle\Entity\Import;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class ImportController extends GenericController
{
    public function importAction()
    {

    }

    /**
     * @Template()
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request)
    {
        $import = new Import();
        $form = $this->createForm('import', $import);
        $form->handleRequest($request);

        if ($form->isValid()) {
            var_dump($form->getData());
            var_dump($import);

            die('lol');
        }
        return [
            'form' => $form->createView()
        ];
    }
}
