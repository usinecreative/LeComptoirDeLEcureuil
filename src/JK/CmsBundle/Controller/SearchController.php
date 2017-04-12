<?php

namespace JK\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function searchAction(Request $request)
    {
        if ($request->get('search')) {
            return $this
                ->get('cms.search.form_handler')
                ->handle($request)
            ;
        }
        // by default redirect to the referer
        $url = $request
            ->headers
            ->get('referer')
        ;

        // if no referer, redirect to the homepage
        if (null === $url) {
            $url = $this->generateUrl('lecomptoir.homepage');
        }

        return $this->redirect($url);
    }
}
