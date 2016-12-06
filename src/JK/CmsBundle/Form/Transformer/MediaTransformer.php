<?php

namespace JK\CmsBundle\Form\Transformer;

use JK\CmsBundle\Entity\MediaInterface;
use JK\CmsBundle\Repository\MediaRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Transform an Media to an array of data and reverse transform this array into a Media using the id
 */
class MediaTransformer implements DataTransformerInterface
{
    /**
     * @var MediaRepository
     */
    protected $mediaRepository;
    
    /**
     * CategoryType constructor.
     *
     * @param MediaRepository $mediaRepository
     */
    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }
    
    /**
     * Return the media id or null if the Media is null.
     *
     * @param MediaInterface $media
     *
     * @return string
     */
    public function transform($media)
    {
        // the media can be null if the column in the linked entity is nullable
        if (null === $media) {
            return [];
        }
        
        return [
            'id' => $media->getId(),
            'filename' => $media->getFileName(),
        ];
    }
    
    /**
     * Return the Media or null if the id is null.
     *
     * @param mixed $data
     *
     * @return MediaInterface|null|object
     */
    public function reverseTransform($data)
    {
        if (0 === count($data) || !array_key_exists('id', $data)) {
            return null;
        }
        
        return $this
            ->mediaRepository
            ->find($data['id']);
    }
}
