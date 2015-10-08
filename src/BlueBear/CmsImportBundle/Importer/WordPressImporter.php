<?php

namespace BlueBear\CmsImportBundle\Importer;


use BlueBear\BaseBundle\Behavior\ContainerTrait;
use BlueBear\CmsImportBundle\Entity\Import;
use Symfony\Component\Filesystem\Filesystem;

class WordPressImporter implements ImporterInterface
{
    use ContainerTrait;

    public function import(Import $import)
    {
        $filePath = $import->getfilePath() . '/' . $import->getFileName();
        $fileSystem = new Filesystem();

        //if ($fileSystem->)
    }

    protected function importFromXml($xml)
    {
        // xml required namespaces
        $dcNamespace = 'http://purl.org/dc/elements/1.1/';
        $contentNamespace = 'http://purl.org/rss/1.0/modules/content/';
        $wpNamespace = 'http://wordpress.org/export/1.2/';

        $doctrine = $this
            ->container
            ->get('doctrine');
        // wordpress needed info are stored in node channel->item
        if ($xml->channel) {
            if ($xml->channel->item) {
                /** @var SimpleXMLElement $item */
                foreach ($xml->channel->item as $item) {
                    $userName = (string)$item->children($dcNamespace)->creator;
                    // find an existing user with this name
                    $author = $doctrine
                        ->getRepository('BlueBearCmsUserBundle:User')
                        ->findOneBy([
                            'username' => $userName
                        ]);

                    if (!$author) {
                        $author = new User();
                        $author->setUsername($item->children($dcNamespace)->author);
                    }
                    // check if article allow comments
                    $isCommentable = ($item->children($wpNamespace)->comment_status == 'open') ? true : false;
                    // check publication status. Not published items will be set as draft
                    $publicationStatus = ($item->children($wpNamespace)->status == 'publish') ?
                        Article::PUBLICATION_STATUS_PUBLISHED : Article::PUBLICATION_STATUS_DRAFT;

                    // cehck for an existing category
                    $categoryName = (string)$item->category;
                    $category = $doctrine
                        ->getRepository('BlueBearCmsBundle:Category')
                        ->findOneBy([
                            'name' => $categoryName
                        ]);
                    // if not create new one
                    if (!$category) {
                        $category = new Category();
                        $category->setName($categoryName);
                        $category->setPublicationStatus(Category::PUBLICATION_NOT_PUBLISHED);
                    }
                    // creating article
                    $article = new Article();
                    $article->setTitle((string)$item->title);
                    $article->setCanonical((string)$item->link);
                    $article->setPublicationDate((new DateTime())->setTimestamp(strtotime($item->pubDate)));
                    $article->setAuthor($author);
                    $article->setContent((string)$item->children($contentNamespace)->encoded);
                    $article->forceCreatedAt((new DateTime())->setTimestamp(strtotime($item->children($wpNamespace)->post_date)));
                    $article->setIsCommentable($isCommentable);
                    $article->setPublicationStatus($publicationStatus);
                    $article->setCategory($category);

                    if ($article->isCommentable()) {
                        foreach ($item->children($wpNamespace)->comment as $commentItem) {
                            // convert timestamp to DateTime
                            $commentDate = (new DateTime())->setTimestamp(strtotime($commentItem->comment_date));
                            // creating commment
                            $comment = new Comment();
                            $comment->setAuthorName($commentItem->comment_author);
                            $comment->setAuthorEmail($commentItem->comment_author_email);
                            $comment->setAuthorUrl($commentItem->comment_author_url);
                            $comment->setAuthorIp($commentItem->comment_author_ip);
                            $comment->forceCreatedAt($commentDate);
                            $comment->setContent($commentItem->comment_content);
                            $comment->setIsApproved((bool)$commentItem->comment_author);
                            $comment->setArticle($article);

                            foreach ($commentItem->children($wpNamespace)->commentmeta as $commentMeta) {
                                $comment->addMetadata((string)$commentMeta->key, (string)$commentMeta->value);
                            }
                            $doctrine->getManager()->persist($comment);
                            $article->addComment($comment);
                        }
                    }
                    // persisting changes
                    $doctrine->getManager()->persist($author);
                    $doctrine->getManager()->persist($category);
                    $doctrine->getManager()->persist($article);
                    // we need to flush to create new categories in database and then not importing them twice
                    $doctrine->getManager()->flush();
                }
                $doctrine->getManager()->flush();
            }
        }
    }
}
