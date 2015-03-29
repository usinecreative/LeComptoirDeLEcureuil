<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use BlueBear\CmsBundle\Entity\Content;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContentController extends Controller
{
    use ControllerTrait;

    /**
     * @Template()
     * @param Request $request
     * @return array
     */
    public function listAction(Request $request)
    {
        $adapter = new DoctrineORMAdapter($this
            ->get('bluebear.cms.manager.content')
            ->findByTypeQueryBuilder($request->get('type')));
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(50);
        $pager->setCurrentPage($request->get('page', 1));

        return [
            'pager' => $pager
        ];
    }

    /**
     * @Template("@BlueBearCms/Content/edit.html.twig")
     * @param Request $request
     * @return array
     */
    public function editAction(Request $request)
    {
        $this->forward404Unless($type = $request->get('type'), 'Content name not found');

        if ($id = $request->get('id')) {
            /** @var Content $content */
            $content = $this
                ->get('bluebear.cms.manager.content')
                ->find($request->get('id'));
        } else {
            // create content from type
            $content = $this
                ->get('bluebear.cms.manager.content')
                ->create($type);
        }
        $form = $this->createForm('content', $content);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('bluebear.cms.manager.content')->save($content);
            $this->addFlash('info', 'bluebear.cms.content.saved');

            if ($request->request->get('submit') == 'save') {
                return $this->redirect('@bluebear.cms.content.edit', [
                    'id' => $content->getId(),
                    'type' => $content->getType()
                ]);
            } else {
                // redirect to list
                return $this->redirect('@bluebear.cms.content.list', [
                    'type' => $content->getType()
                ]);
            }
        }
        return [
            'form' => $form->createView()
        ];
    }

    public function deleteAction($id, $type)
    {
    }
}
