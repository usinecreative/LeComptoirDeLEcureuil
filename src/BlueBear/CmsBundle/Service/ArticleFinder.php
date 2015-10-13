<?php

namespace BlueBear\CmsBundle\Service;

use BlueBear\CmsBundle\Service\Filter\ArticleFilter;
use Symfony\Component\HttpFoundation\Request;

class ArticleFinder
{
    public function handleRequest(Request $request)
    {
        if ($request->get('year') && $request->get('month') && $request->get('slug')) {

        }
        die('end');
    }

    public function find(ArticleFilter $filter)
    {
        if ($filter->isValid()) {

        } else {
            die('pas content');
        }


        die('lol');
    }
}
