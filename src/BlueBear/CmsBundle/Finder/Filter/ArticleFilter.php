<?php

namespace BlueBear\CmsBundle\Finder\Filter;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Article filter is use to find Article with ArticleFinder
 */
class ArticleFilter
{
    /**
     * @var ParameterBag
     */
    protected $parameters;

    /**
     * @var ParameterBag
     */
    protected $allowedParameters;

    /**
     * ArticleFilter constructor. Initialize parameters and allowed parameters bag
     */
    public function __construct()
    {
        $this->parameters = new ParameterBag();
        $this->allowedParameters = new ParameterBag([
            'categorySlug' => 'string',
            'tag' => 'string',
            'slug' => 'string',
            'year' => 'string',
            'month' => 'string'
        ]);
    }

    /**
     * Search parameters value from request according to allowed parameters
     *
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $resolver = new OptionsResolver();

        foreach ($this->allowedParameters as $parameter => $type) {
            $value = $request->get($parameter);

            if ($value) {
                // resolve value according to allowed types
                $resolver
                    ->clear()
                    ->setRequired($parameter)
                    ->setAllowedTypes($parameter, $type)
                    ->resolve([
                        $parameter => $value
                    ]);
                // add correct filter parameter to the bag
                $this
                    ->parameters
                    ->set($parameter, $value);
            }
        }
    }

    /**
     * Return parameters computed by handleRequest method
     *
     * @return ParameterBag
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
