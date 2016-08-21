<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use LAG\AdminBundle\Controller\CRUDController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ArticleController extends CRUDController
{
    use ControllerTrait;

    /**
     * @Template()
     * @param Request $request
     * @return array
     */
    public function previewAction(Request $request)
    {
        $article = $this
            ->get('jk.cms.article_repository')
            ->find($request->get('id'));
        $this->forward404Unless($article);

        return [
            'article' => $article
        ];
    }

    /**
     * Generic edit action.
     *
     * @Template("LAGAdminBundle:CRUD:edit.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function editAction(Request $request)
    {
        $admin = $this->getAdminFromRequest($request);
        $admin->handleRequest($request, $this->getUser());
        // check permissions
        $this->forward404IfNotAllowed($admin);
        // create form
        $form = $this->createForm($admin->getConfiguration()->getParameter('form'), $admin->getUniqueEntity());
        $form->handleRequest($request);
        $accessor = PropertyAccess::createPropertyAccessor();

        if ($form->isValid()) {
            $admin->save();
            $this
                ->get('bluebear.cms.article.handler')
                ->handle($form);

            if ($request->request->get('submit') == 'save') {
                $saveRoute = $admin->generateRouteName('edit');

                return $this->redirectToRoute($saveRoute, [
                    'id' => $accessor->getValue($admin->getUniqueEntity(), 'id'),
                ]);
            } else {
                $listRoute = $admin->generateRouteName('list');
                // redirect to list
                return $this->redirectToRoute($listRoute);
            }
        }

        return [
            'admin' => $admin,
            'form' => $form->createView(),
        ];
    }
}
