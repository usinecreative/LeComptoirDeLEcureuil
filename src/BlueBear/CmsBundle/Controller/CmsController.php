<?php

namespace BlueBear\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CmsController extends Controller
{
    /**
     * @Template()
     *
     * @return array
     */
    public function homepageAction()
    {
        $categories = $this
            ->get('jk.cms.category_repository')
            ->findAll();

        return [
            'categories' => $categories,
        ];
    }
}
