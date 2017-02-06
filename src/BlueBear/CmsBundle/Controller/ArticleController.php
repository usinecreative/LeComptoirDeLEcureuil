<?php

namespace BlueBear\CmsBundle\Controller;

use LAG\AdminBundle\Controller\CRUDController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends CRUDController
{
    /**
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function previewAction(Request $request)
    {
        $article = $this
            ->get('cms.article.repository')
            ->find($request->get('id'));
        $this->forward404Unless($article);

        return $this->redirectToRoute('lecomptoir.article.show', $article->getUrlParameters());
    }
}
