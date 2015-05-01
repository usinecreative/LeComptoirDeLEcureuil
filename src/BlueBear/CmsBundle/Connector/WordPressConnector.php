<?php

namespace BlueBear\CmsBundle\Connector;


use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsUserBundle\Entity\User;
use DateTime;
use SimpleXMLElement;

class WordPressConnector
{
    public function importXml($xml)
    {
        $articles = [];
        $categories = [];
        $users = [];

        $dcNamespace = 'http://purl.org/dc/elements/1.1/';
        $contentNamespace = 'http://purl.org/rss/1.0/modules/content/';
        $wpNamespace = 'http://wordpress.org/export/1.2/';

        if ($xml->channel) {
            if ($xml->channel->item) {
                /** @var SimpleXMLElement $item */
                foreach ($xml->channel->item as $item) {
                    $author = new User();
                    $author->setUsername($item->children($dcNamespace)->author);
                    $isCommentable = ($item->children($wpNamespace)->comment_status == 'open') ? true : false;
                    $publicationStatus = ($item->children($wpNamespace)->status == 'publish') ?
                        Article::PUBLICATION_STATUS_PUBLISHED : Article::PUBLICATION_STATUS_DRAFT;

                    $article = new Article();
                    $article->setTitle($item->title);
                    $article->setCanonical($item->url);
                    $article->setPublicationDate((new DateTime())->setTimestamp(strtotime($item->pubDate)));
                    $article->setAuthor($author);
                    $article->setContent((string)$item->children($contentNamespace)->encoded);
                    $article->setCreatedAt((new DateTime())->setTimestamp(strtotime($item->children($wpNamespace)->post_date)));
                    $article->setIsCommentable($isCommentable);
                    $article->setPublicationStatus($publicationStatus);
                    $article->setCategory((string)$item->category);

                    // TODO add cms comments

                    die;
                }

            }
        }
    }
}