<?php

namespace BlueBear\CmsBundle\Repository;

use BlueBear\CmsBundle\Entity\Comment;
use DateTime;
use LAG\AdminBundle\Doctrine\Repository\DoctrineRepository;

class CommentRepository extends DoctrineRepository
{
    /**
     * Return all comments created after $date.
     *
     * @param DateTime $date
     *
     * @return array
     */
    public function findByDate(DateTime $date)
    {
        return $this
            ->createQueryBuilder('comment')
            ->where('comment.createdAt > :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find all Comments from an Article that should be notified in case of new Comment.
     *
     * @param Comment $comment
     *
     * @return Comment[]
     */
    public function findShouldBeNotified(Comment $comment)
    {
        return $this
            ->createQueryBuilder('comment')
            ->where('comment.article = :article')
            ->andWhere('comment.notifyNewComments = :notify')
            ->andWhere('comment.id != :id')
            ->setParameter('article', $comment->getArticle()->getId())
            ->setParameter('notify', true)
            ->setParameter('id', $comment->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Unsubscribe an email from the notifications send on new Comment.
     *
     * @param string $articleSlug
     * @param string $email
     */
    public function unsubscribe($articleSlug, $email)
    {
        /** @var Comment[] $comments */
        $comments = $this
            ->createQueryBuilder('comment')
            ->innerJoin('comment.article', 'article')
            ->where('article.slug = :slug')
            ->andWhere('comment.authorEmail = :email')
            ->setParameter('slug', $articleSlug)
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult();

        foreach ($comments as $comment) {
            $comment->setNotifyNewComments(false);
            $this->save($comment);
        }
    }

    /**
     * Return the number of new Comment after a given date. If no Date is provided, return the number of all Comments.
     *
     * @param DateTime|null $dateTime
     *
     * @return int
     */
    public function findNewCommentCount(DateTime $dateTime = null)
    {
        $queryBuilder = $this
            ->createQueryBuilder('comment')
            ->select('count(comment.id)')
        ;

        if (null !== $dateTime) {
            $queryBuilder
                ->where('comment.createdAt >= :date')
                ->setParameter('date', $dateTime)
            ;
        }

        return $queryBuilder
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
