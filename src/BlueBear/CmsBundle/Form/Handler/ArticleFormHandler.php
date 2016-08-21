<?php

namespace BlueBear\CmsBundle\Form\Handler;

use BlueBear\CmsBundle\Entity\Article;
use BlueBear\MediaBundle\Entity\Media;
use BlueBear\MediaBundle\Repository\MediaRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleFormHandler
{
    /**
     * @var string
     */
    protected $webDirectory;
    /**
     * @var MediaRepository
     */
    private $mediaRepository;

    /**
     * ArticleFormHandler constructor.
     *
     * @param string $webDirectory
     * @param MediaRepository $mediaRepository
     */
    public function __construct($webDirectory, MediaRepository $mediaRepository)
    {
        $this->webDirectory = realpath($webDirectory.'/../web');
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * @param FormInterface $form
     */
    public function handle(FormInterface $form)
    {
        return;
        $article = $form->getData();

        if (!($article instanceof Article)) {
            return;
        }
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $article->getThumbnail();

        if (!($uploadedFile instanceof UploadedFile)) {
            return;
        }
        $movedFile = $uploadedFile->move($this->webDirectory.'/uploads');
        $media = new Media();
        $media->setFilepath($movedFile->getRealPath());
        $media->setType(Media::MEDIA_TYPE_IMAGE);
        $media->setName($media->getFilename());
        $media->setSize($media->getSize());
        $article->setThumbnail($media);

        $this
            ->mediaRepository
            ->save($media);
    }
}
