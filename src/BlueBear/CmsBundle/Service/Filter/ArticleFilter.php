<?php

namespace BlueBear\CmsBundle\Service\Filter;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFilter
{
    protected $categorySlug;
    protected $year;
    protected $month;
    protected $slug;
    protected $isValid = false;

    public function handleRequest(Request $request)
    {
        $resolver = new OptionsResolver();

        if ($request->get('year') && $request->get('month') && $request->get('slug')) {
            $resolver->setRequired([
                'year',
                'month',
                'slug',
            ]);
            $resolver->setAllowedTypes('year', 'integer');
            $resolver->setAllowedTypes('month', 'integer');
            $resolver->setAllowedTypes('slug', 'string');
            $resolver->resolve([
                'year' => (int)$request->get('year'),
                'month' => (int)$request->get('month'),
                'slug' => $request->get('slug'),
            ]);
            $this->year = (int)$request->get('year');
            $this->month = (int)$request->get('month');
            $this->slug = (int)$request->get('slug');
            $this->isValid = true;
        }
    }

    /**
     * @return string
     */
    public function getCategorySlug()
    {
        return $this->categorySlug;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $categorySlug
     */
    public function setCategorySlug($categorySlug)
    {
        $this->categorySlug = $categorySlug;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @param boolean $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }
}
