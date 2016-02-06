<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
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
            ->get('lag.cms.article_repository')
            ->find($request->get('id'));
        $this->forward404Unless($article);

        return [
            'article' => $article
        ];
    }
}
