<?php

namespace BlueBear\CmsBundle\Import\Importer;

use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Entity\Category;
use BlueBear\CmsBundle\Entity\Comment;
use BlueBear\CmsBundle\Entity\Import;
use BlueBear\CmsBundle\Entity\Tag;
use BlueBear\CmsBundle\Entity\User;
use BlueBear\CmsBundle\Exception\ImportException;
use BlueBear\CmsBundle\Import\ImporterInterface;
use BlueBear\CmsBundle\Repository\ArticleRepository;
use BlueBear\CmsBundle\Repository\CategoryRepository;
use BlueBear\CmsBundle\Repository\TagRepository;
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
    const DC_NAMESPACE = 'http://purl.org/dc/elements/1.1/';

    const WP_NAMESPACE = 'http://wordpress.org/export/1.2/';

    const CONTENT_NAMESPACE = 'http://purl.org/rss/1.0/modules/content/';

    /**
     * @var LoggerInterface
     */
    protected $logger;

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
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * WordPressImporter constructor.
     *
     * @param LoggerInterface $logger
     * @param CategoryRepository $categoryRepository
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     * @param TagRepository $tagRepository
     */
    public function __construct(
        LoggerInterface $logger,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository,
        ArticleRepository $articleRepository,
        TagRepository $tagRepository
    ) {
        $this->logger = $logger;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->tagRepository = $tagRepository;
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
                    $this->importTag($item);

                    /*if ($article->isCommentable()) {
                        foreach ($item->children($WP_NAMESPACE)->comment as $commentItem) {
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

                            foreach ($commentItem->children($WP_NAMESPACE)->commentmeta as $commentMeta) {
                                $comment->addMetadata((string)$commentMeta->key, (string)$commentMeta->value);
                            }
                            $this->doctrine->getManager()->persist($comment);
                            $article->addComment($comment);
                        }
                    }*/
                    // persisting changes
                    //$this->doctrine->getManager()->persist($author);

                    //$this->doctrine->getManager()->persist($article);
                    // we need to flush to create new categories in database and then not importing them twice
                    //$this->doctrine->getManager()->flush();
                }
                //$this->doctrine->getManager()->flush();
            }
        }
        die;
    }

    /**
     * Import a category from an xml element
     *
     * @param SimpleXMLElement $element
     */
    protected function importCategory(SimpleXMLElement $element)
    {
        // convert xml element to string
        $categoryName = '';

        // WordPress xml export has many <category> but only one is an actual category; we must to find it
        foreach ($element->category as $categoryElement) {

            if ((string)$categoryElement['domain'] == 'category') {
                $categoryName = (string)$categoryElement;
                break;
            }
        }
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
        $userName = (string)$element->children(self::DC_NAMESPACE)->creator;

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
            $author->setUsername($element->children(self::DC_NAMESPACE)->author);
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
        $postType = (string)$element->children(self::WP_NAMESPACE)->post_type;

        if ($postType != 'post') {
            return;
        }
        $authorName = (string)$element->children(self::DC_NAMESPACE)->creator;

        // author must exist
        $author = $this->userRepository->findOneBy([
            'username' => $authorName
        ]);

        if (!$author) {
            throw new ImportException("Author {$authorName} not found");
        }
        $isCommentable = ((string)$element->children(self::WP_NAMESPACE)->comment_status == 'open') ? true : false;
        $categoryName = '';

        // WordPress xml export has many <category> but only one is an actual category; we must to find it
        foreach ($element->category as $categoryElement) {

            if ((string)$categoryElement['domain'] == 'category') {
                $categoryName = (string)$categoryElement;
                break;
            }
        }
        $articleName = (string)$element->title;

        $category = $this->categoryRepository->findOneBy([
            'name' => $categoryName
        ]);

        if (!$category) {
            throw new ImportException("Category {$category} not found for article {$articleName}");
        }

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
        $article->setContent((string)$element->children(self::CONTENT_NAMESPACE)->encoded);
        $article->forceCreatedAt((new DateTime())->setTimestamp(strtotime($element->children(self::WP_NAMESPACE)->post_date)));
        $article->setIsCommentable($isCommentable);
        $article->setPublicationStatus(Article::PUBLICATION_STATUS_VALIDATION);
        $article->setCategory($category);
        $article->setSlug((string)$element->children(self::WP_NAMESPACE)->post_name[0]);

        $this
            ->articleRepository
            ->save($article);
    }

    /**
     * Import a tag fron an xml element
     *
     * @param SimpleXMLElement $element
     */
    protected function importTag(SimpleXMLElement $element)
    {
        $tagName = '';

        foreach ($element->category as $categoryElement) {

            if ((string)$categoryElement['domain'] == 'post_tag') {
                $tagName = (string)$categoryElement;
                break;
            }
        }
        if (!$tagName) {
            return;
        }
        $tagName = str_replace("\n", '', $tagName);
        $tagName = trim($tagName);

        // check for an existing tag
        $tag = $this
            ->tagRepository
            ->findOneBy([
                'name' => $tagName
            ]);

        // if not create new one
        if (!$tag) {
            $tag = new Tag();
            $tag->setName($tagName);
        }
        $this
            ->tagRepository
            ->save($tag);

        // find a linked article
        $articleName = (string)$element->title;

        /** @var Article $article */
        $article = $this->articleRepository->findOneBy([
            'title' => $articleName
        ]);

        if ($article) {
            $article->addTag($tag);
            $this->articleRepository->save($article);
            $this
                ->tagRepository
                ->save($tag);
        }
    }
}
