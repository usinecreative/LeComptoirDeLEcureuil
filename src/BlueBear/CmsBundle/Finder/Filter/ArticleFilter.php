<?php

namespace BlueBear\CmsBundle\Finder\Filter;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

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
            'categorySlug',
            'tagSlug',
            'tag',
            'slug',
            'year',
            'month',
            'page'
        ]);
    }

    /**
     * Search parameters value from request according to allowed parameters
     *
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        foreach ($this->allowedParameters as $parameter) {
            $value = $request->get($parameter);

            if ($value !== null) {
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

    /**
     * Return a parameter value by its name
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function getParameter($name, $default = null)
    {
        return $this
            ->parameters
            ->get($name, $default);
    }
}
