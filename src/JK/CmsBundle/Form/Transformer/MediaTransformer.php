<?php

namespace JK\CmsBundle\Form\Transformer;

use JK\CmsBundle\Assets\AssetsHelper;
use JK\CmsBundle\Entity\MediaInterface;
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
     */
    public function __construct(AssetsHelper $assetsHelper)
    {
        $this->assetsHelper = $assetsHelper;
    }

    /**
     * Transform the Media filename into an UploadedFile to be compatible with the File form type.
     *
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
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
     * Upload the new Media file if provided using the assets helper.
     *
     * @param MediaInterface|null $media
     *
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
        } elseif (null === $uploadedFile) {
            // if no file was uploaded, we must set the original filename to avoid setting null to the property
            $media->setFileName($this->originalFileName);
        }

        return $media;
    }

    /**
     * Define the original filename to avoid setting null in case of no new file was uploaded.
     *
     * @param string $fileName
     */
    public function setOriginalFileName($fileName)
    {
        $this->originalFileName = $fileName;
    }
}
