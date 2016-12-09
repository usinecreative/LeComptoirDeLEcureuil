<?php

namespace BlueBear\CmsBundle\Dashboard\Factory;

use BlueBear\CmsBundle\Dashboard\Dashboard;
use BlueBear\CmsBundle\Dashboard\DashboardItem;
use JK\CmsBundle\Repository\ArticleRepository;
use BlueBear\CmsBundle\Repository\CommentRepository;
use DateTime;

class DashboardFactory
{
    /**
     * @var CommentRepository
     */
    protected $commentRepository;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(
        CommentRepository $commentRepository,
        ArticleRepository $articleRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->articleRepository = $articleRepository;
    }
    
    /**
     * @param DateTime $lastLogin
     *
     * @return Dashboard
     */
    public function create(DateTime $lastLogin)
    {
        $dashboard = new Dashboard();
        $this->createHeaders($dashboard, $lastLogin);

        return $dashboard;
    }
    
    /**
     * @param Dashboard $dashboard
     * @param DateTime $lastLogin
     */
    protected function createHeaders(Dashboard $dashboard, DateTime $lastLogin)
    {
        // new comments item
        $comments = $this
            ->commentRepository
            ->findByDate($lastLogin);
        $dashboard->addHeadingItem(new DashboardItem(
            count($comments),
            'lag.cms.new_comments',
            null,
            'comments',
            'primary'
        ));
        // new articles item
        $articles = $this
            ->articleRepository
            ->findByDate($lastLogin);
        $dashboard->addHeadingItem(new DashboardItem(
            count($articles),
            'lag.cms.new_articles',
            null,
            'newspaper-o',
            'green'
        ));
        // not published articles item
        $articles = $this
            ->articleRepository
            ->findNotPublished();
        $dashboard->addHeadingItem(new DashboardItem(
            count($articles),
            'lag.cms.articles_not_published',
            null,
            'newspaper-o',
            'yellow'
        ));
    }
}
