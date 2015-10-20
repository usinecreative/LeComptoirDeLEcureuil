<?php

namespace BlueBear\MediaBundle\Controller;

use BlueBear\AdminBundle\Controller\GenericController;
use BlueBear\BaseBundle\Behavior\ControllerTrait;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends GenericController
{
    use ControllerTrait;

//    public function listAction(Request $request, $type = null)
//    {
//        if ($type) {
//            $medias = $this
//                ->get('bluebear.media.manager')
//                ->findOneBy([
//                    'type' => $type
//                ]);
//        } else {
//            $medias = $this
//                ->get('bluebear.media.manager')
//                ->findAll();
//        }
//        $admin = $this
//            ->get('bluebear.admin.factory')
//            ->getAdminFromRequest($request);
//        $admin->setEntities($medias);
//
//        return $this->render('@BlueBearAdmin/Generic/list.html.twig', [
//            'admin' => $admin
//        ]);
//    }

    public function uploadAction(Request $request)
    {
        $form = $this
            ->createForm('upload');
        die('in progress');
    }
}
