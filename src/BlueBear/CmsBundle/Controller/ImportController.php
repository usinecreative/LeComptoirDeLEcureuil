<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\CmsBundle\Form\Type\ImportType;
use LAG\AdminBundle\Controller\CRUDController;
use BlueBear\CmsBundle\Entity\Import;
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
        $form = $this->createForm(ImportType::class, $import);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $importer = $this
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
