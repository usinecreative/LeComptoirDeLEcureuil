<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use BlueBear\CmsBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    use ControllerTrait;

    public function showAction(Article $article)
    {

    }

    /**
     * @Template()
     * @param $categorySlug
     * @return array
     */
    public function listByCategorieAction($categorySlug)
    {
        $articles = $this
            ->getDoctrine()
            ->getRepository('BlueBearCmsBundle:Article')
            ->findByCategory($categorySlug);

        return [
            'articles' => $articles
        ];
    }
}
