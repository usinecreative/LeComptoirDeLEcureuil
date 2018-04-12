<?php

namespace JK\CmsBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function dashboardAction()
    {
        $user = $this->getUser();
        $newCommentCount = $this
            ->get('jk.cms.comment_repository')
            ->findNewCommentCount($user->getCommentLastViewDate())
        ;

        return $this->render('@JKCms/Dashboard/dashboard.html.twig', [
            'newCommentCount' => $newCommentCount,
        ]);
    }

    public function goToNewCommentsAction()
    {
        $user = $this->getUser();
        $user->setCommentLastViewDate(new DateTime());
        $this
            ->get('jk.cms.user_repository')
            ->save($user)
        ;

        return $this->redirectToRoute('cms.comment.list');
    }
}
