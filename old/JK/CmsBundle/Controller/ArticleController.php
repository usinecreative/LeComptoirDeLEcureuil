<?php

namespace JK\CmsBundle\Controller;

use App\Entity\Article;
use LAG\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends CRUDController
{
    /**
     * On article creation, save the article and redirect on edit to have tinymce available.
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $admin = $this->getAdminFromRequest($request);
        $admin->handleRequest($request, $this->getUser());

        // check permissions
        $this->forward404IfNotAllowed($admin);

        /** @var Article $entity */
        $entity = $admin->create();
        $entity->setPublicationStatus(Article::PUBLICATION_STATUS_DRAFT);
        $admin->save();

        return $this->redirectToRoute('cms.article.edit', [
            'id' => $entity->getId(),
        ]);
    }
}
