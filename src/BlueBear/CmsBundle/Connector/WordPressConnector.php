<?php

namespace BlueBear\CmsBundle\Connector;


use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Entity\Category;
use BlueBear\CmsBundle\Entity\Comment;
use BlueBear\CmsUserBundle\Entity\User;
use DateTime;
use SimpleXMLElement;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WordPressConnector
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function importXml($xml)
    {
        $dcNamespace = 'http://purl.org/dc/elements/1.1/';
        $contentNamespace = 'http://purl.org/rss/1.0/modules/content/';
        $wpNamespace = 'http://wordpress.org/export/1.2/';

        $doctrine = $this
            ->container
            ->get('doctrine');

        if ($xml->channel) {
            if ($xml->channel->item) {
                /** @var SimpleXMLElement $item */
                foreach ($xml->channel->item as $item) {
                    $userName = (string)$item->children($dcNamespace)->creator;
                    // find an existing user with this name
                    $author = $doctrine
                        ->getRepository('BlueBearCmsUserBundle:User')
                        ->findOneBy([
                            'username'=> $userName
                        ]);

                    if (!$author) {
                        $author = new User();
                        $author->setUsername($item->children($dcNamespace)->author);
                    }
                    $isCommentable = ($item->children($wpNamespace)->comment_status == 'open') ? true : false;
                    $publicationStatus = ($item->children($wpNamespace)->status == 'publish') ?
                        Article::PUBLICATION_STATUS_PUBLISHED : Article::PUBLICATION_STATUS_DRAFT;

                    $categoryName = (string)$item->category;
                    $category = $doctrine
                        ->getRepository('BlueBearCmsBundle:Category')
                        ->findOneBy([
                            'name' => $categoryName
                        ]);

                    if (!$category) {
                        $category = new Category();
                        $category->setName($categoryName);
                        $category->setPublicationStatus(Category::PUBLICATION_NOT_PUBLISHED);
                    }
                    $article = new Article();
                    $article->setTitle((string)$item->title);
                    $article->setCanonical((string)$item->link);
                    $article->setPublicationDate((new DateTime())->setTimestamp(strtotime($item->pubDate)));
                    $article->setAuthor($author);
                    $article->setContent((string)$item->children($contentNamespace)->encoded);
                    $article->setCreatedAt((new DateTime())->setTimestamp(strtotime($item->children($wpNamespace)->post_date)));
                    $article->setIsCommentable($isCommentable);
                    $article->setPublicationStatus($publicationStatus);
                    $article->setCategory($category);

                    foreach ($item->children($wpNamespace)->comment as $commentItem) {
                        $comment = new Comment();
                        $comment->setAuthorName($commentItem->comment_author);
                        $comment->setAuthorEmail($commentItem->comment_author_email);
                        $comment->setAuthorUrl($commentItem->comment_author_url);
                        $comment->setAuthorIp($commentItem->comment_author_ip);
                        $comment->setCreatedAt($commentItem->comment_date);
                        $comment->setContent($commentItem->comment_content);
                        $comment->setIsApproved((bool)$commentItem->comment_author);
                        $comment->setArticle($article);

                        foreach ($commentItem->children($wpNamespace)->commentmeta as $commentMeta) {
                            $comment->addMetadata((string)$commentMeta->key, (string)$commentMeta->value);
                        }
                        $doctrine->getManager()->persist($comment);
                        $article->addComment($comment);
                    }
                    $doctrine->getManager()->persist($author);
                    $doctrine->getManager()->persist($category);
                    $doctrine->getManager()->persist($article);
                }
                $doctrine->getManager()->flush();
            }
        }
    }
}