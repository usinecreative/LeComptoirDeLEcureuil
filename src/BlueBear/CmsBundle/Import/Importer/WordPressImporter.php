<?php

namespace BlueBear\CmsBundle\Import\Importer;

use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Entity\Category;
use BlueBear\CmsBundle\Entity\Comment;
use BlueBear\CmsBundle\Entity\Import;
use BlueBear\CmsBundle\Entity\User;
use BlueBear\CmsBundle\Exception\ImportException;
use BlueBear\CmsBundle\Import\ImporterInterface;
use BlueBear\CmsBundle\Repository\ArticleRepository;
use BlueBear\CmsBundle\Repository\CategoryRepository;
use BlueBear\CmsBundle\Repository\UserRepository;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Exception;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Filesystem\Filesystem;

class WordPressImporter implements ImporterInterface
{
    protected $dcNamespace = 'http://purl.org/dc/elements/1.1/';

    protected $wpNamespace = 'http://wordpress.org/export/1.2/';

    protected $contentNamespace = 'http://purl.org/rss/1.0/modules/content/';

    protected $logger;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var ArticleRepository
     */
    protected $articleRepository;

    /**
     * WordPressImporter constructor.
     *
     * @param LoggerInterface $logger
     * @param Registry $doctrine
     * @param CategoryRepository $categoryRepository
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(
        LoggerInterface $logger,
        Registry $doctrine,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository,
        ArticleRepository $articleRepository
    ) {
        $this->logger = $logger;
        $this->doctrine = $doctrine;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
    }

    public function import(Import $import)
    {
        $filePath = $import->getfilePath() . '/' . $import->getFileName();
        $fileSystem = new Filesystem();

        if ($fileSystem->exists($filePath)) {
            $xml = simplexml_load_file($filePath);

            try {
                $this->importFromXml($xml);
                $import->setStatus(Import::IMPORT_STATUS_SUCCESS);
            } catch (Exception $e) {
                $this->logger->log(Logger::ERROR, 'An error has occured during a import : ' . $e->getMessage() . ' ' . $e->getTraceAsString());
                $import->setStatus(Import::IMPORT_STATUS_ERROR);

                throw $e;
            }
            $import->setLabel('Test import');
            $this->doctrine->getManager()->persist($import);
            $this->doctrine->getManager()->flush($import);
        }
    }

    protected function importFromXml($xml)
    {
        // xml required namespaces



        // wordpress needed info are stored in node channel->item
        if ($xml->channel) {
            if ($xml->channel->item) {
                /** @var SimpleXMLElement $item */
                foreach ($xml->channel->item as $item) {


                    $this->importCategory($item);
                    $this->importUser($item);
                    $this->importArticle($item);
                    continue;

                    $userName = (string)$item->children($dcNamespace)->creator;
                    // find an existing user with this name
                    $author = $this
                        ->doctrine
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

                    // check for an existing category
                    $categoryName = (string)$item->category;
                    $category = $this
                        ->doctrine
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
                    $article->setSlug((string)$item->children($wpNamespace)->post_name[0]);

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
                            $this->doctrine->getManager()->persist($comment);
                            $article->addComment($comment);
                        }
                    }
                    // persisting changes
                    //$this->doctrine->getManager()->persist($author);

                    //$this->doctrine->getManager()->persist($article);
                    // we need to flush to create new categories in database and then not importing them twice
                    //$this->doctrine->getManager()->flush();
                }
                //$this->doctrine->getManager()->flush();
            }
        }
        $this->doctrine->getManager()->flush();
    }

    /**
     * Import a category from an xml element
     *
     * @param SimpleXMLElement $element
     */
    protected function importCategory(SimpleXMLElement $element)
    {
        // convert xml element to string
        $categoryName = (string)$element->category;

        if (!$categoryName) {
            return;
        }

        // check for an existing category
        $category = $this
            ->categoryRepository
            ->findOneBy([
                'name' => $categoryName
            ]);

        // if not create new one
        if (!$category) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setPublicationStatus(Category::PUBLICATION_NOT_PUBLISHED);
        }
        $this
            ->categoryRepository
            ->save($category);
    }

    /**
     * Import an user from an xml element
     *
     * @param SimpleXMLElement $element
     */
    protected function importUser(SimpleXMLElement $element)
    {
        // get user name from element
        $userName = (string)$element->children($this->dcNamespace)->creator;

        if (!$userName) {
            return;
        }
        // find an existing user with this name
        $author = $this
            ->userRepository
            ->findOneBy([
                'username' => $userName
            ]);

        if (!$author) {
            $author = new User();
            $author->setUsername($element->children($this->dcNamespace)->author);
        }
        $this
            ->userRepository
            ->save($author);
    }

    /**
     * Import an article from an xml element
     *
     * @param SimpleXMLElement $element
     * @throws ImportException
     */
    protected function importArticle(SimpleXMLElement $element)
    {
        // only process post type
        $postType = (string)$element->children($this->wpNamespace)->post_type;

        if ($postType != 'post') {
            return;
        }
        $authorName = (string)$element->children($this->dcNamespace)->creator;

        // author must exist
        $author = $this->userRepository->findOneBy([
            'username' => $authorName
        ]);

        if (!$author) {
            throw new ImportException("Author {$authorName} not found");
        }
        $isCommentable = ((string)$element->children($this->wpNamespace)->comment_status == 'open') ? true : false;
        $categoryName = (string)$element->category;

        $category = $this->categoryRepository->findOneBy([
            'name' => $categoryName
        ]);

        if (!$category) {
            throw new ImportException("Category {$category} not found");
        }
        $articleName = (string)$element->title;

        $article = $this->articleRepository->findOneBy([
            'title' => $articleName
        ]);

        if (!$article) {
            $article = new Article();
        }
        $article->setTitle((string)$element->title);
        $article->setCanonical((string)$element->link);
        $article->setPublicationDate((new DateTime())->setTimestamp(strtotime($element->pubDate)));
        $article->setAuthor($author);
        $article->setContent((string)$element->children($this->contentNamespace)->encoded);
        $article->forceCreatedAt((new DateTime())->setTimestamp(strtotime($element->children($this->wpNamespace)->post_date)));
        $article->setIsCommentable($isCommentable);
        $article->setPublicationStatus(Article::PUBLICATION_STATUS_VALIDATION);
        $article->setCategory($category);
        $article->setSlug((string)$element->children($this->wpNamespace)->post_name[0]);

        $this
            ->articleRepository
            ->save($article);
    }
}
