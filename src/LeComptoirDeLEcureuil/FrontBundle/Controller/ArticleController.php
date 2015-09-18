<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use BlueBear\CmsBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    use ControllerTrait;

    public function showAction(Article $article)
    {

    }
}
