<?php

namespace JK\CmsBundle\Entity;

/**
 * A media handled by the CMS should implements this interface.
 */
interface MediaInterface
{
    /**
     * Define the media name.
     *
     * @param int $id
     */
    public function setId($id);
    
    /**
     * Define the media name.
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Define the media file name.
     *
     * @param string $fileName
     */
    public function setFileName($fileName);

    /**
     * Define the media file type (images, audio, video...).
     *
     * @param string $fileType
     */
    public function setFileType($fileType);

    /**
     * Define the media type.
     *
     * @param string $type
     */
    public function setType($type);

    /**
     * Define the media file size.
     *
     * @param int $size
     */
    public function setSize($size);
    
    /**
     * Return the media id.
     *
     * @return string
     */
    public function getId();
    
    /**
     * Return the media name.
     *
     * @return string
     */
    public function getName();

    /**
     * Return the media file name.
     *
     * @return string
     */
    public function getFileName();

    /**
     * Return the media file type.
     *
     * @return string
     */
    public function getFileType();

    /**
     * Return the media file type.
     *
     * @return string
     */
    public function getType();

    /**
     * Return the media file size.
     *
     * @return int
     */
    public function getSize();
}
