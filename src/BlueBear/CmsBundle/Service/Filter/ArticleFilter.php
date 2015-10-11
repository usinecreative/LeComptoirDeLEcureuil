<?php

namespace BlueBear\CmsBundle\Service\Filter;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFilter
{
    protected $categorySlug;

    public function handleRequest(Request $request)
    {
        var_dump($request->query->all());
        die;
        $resolver = new OptionsResolver();
        $resolver->resolve($request->query->all());

        if ($request->get('categorySlug')) {

        }
    }

    /**
     * @return string
     */
    public function getCategorySlug()
    {
        return $this->categorySlug;
    }
}
