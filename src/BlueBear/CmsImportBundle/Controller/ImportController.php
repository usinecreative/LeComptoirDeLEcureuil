<?php

namespace BlueBear\CmsImportBundle\Controller;

use LAG\AdminBundle\Controller\CRUDController;
use BlueBear\CmsImportBundle\Entity\Import;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class ImportController extends CRUDController
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
            $importer = $this
                ->container
                ->get('bluebear.cms.import.importer_factory')
                ->create($import->getType());
            $importer->import($import);

            return $this->redirectToRoute('bluebear.cms.import.list');
        }
        return [
            'form' => $form->createView()
        ];
    }
}
