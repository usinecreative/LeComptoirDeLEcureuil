<?php

namespace JK\CmsBundle\Form\Transformer;

use JK\CmsBundle\Assets\AssetsHelper;
use JK\CmsBundle\Entity\MediaInterface;
use JK\CmsBundle\Repository\MediaRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaTransformer implements DataTransformerInterface
{
    /**
     * @var AssetsHelper
     */
    private $assetsHelper;
    
    /**
     * @var string
     */
    private $originalFileName;
    
    /**
     * MediaEditTransformer constructor.
     *
     * @param AssetsHelper $assetsHelper
     * @param MediaRepository $mediaRepository
     */
    public function __construct(AssetsHelper $assetsHelper, MediaRepository $mediaRepository)
    {
        $this->assetsHelper = $assetsHelper;
    }
    
    public function transform($media)
    {
        if (!$media instanceof MediaInterface) {
            throw new TransformationFailedException('Only '.MediaInterface::class.' can be transformed');
        }
    
        if ($media->getFileName()) {
            $directory = $this
                ->assetsHelper
                ->getMediaDirectory($media->getType());
            $path = $directory.'/'.$media->getFileName();
            $file = new UploadedFile($path, $media->getFileName());
    
            $media->setFileName(new UploadedFile($file, $media->getFileName(), null, null, null, true));
        }
        
        return $media;
    }
    
    /**
     * @param MediaInterface|null $media
     * @return mixed
     */
    public function reverseTransform($media)
    {
        if (null === $media) {
            return $media;
        }
        $uploadedFile = $media->getFileName();
    
        if ($uploadedFile instanceof UploadedFile) {
            $this
                ->assetsHelper
                ->uploadAsset($media, $uploadedFile);
        } else if (null === $uploadedFile) {
            $media->setFileName($this->originalFileName);
        }
    
        return $media;
    }
    
    /**
     * @param string $fileName
     */
    public function setOriginalFileName($fileName)
    {
        $this->originalFileName = $fileName;
    }
}
