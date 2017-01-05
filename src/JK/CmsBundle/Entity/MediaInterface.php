<?php

namespace JK\CmsBundle\Entity;

/**
 * A Media handled by the CMS should implements this interface.
 */
interface MediaInterface
{
    /**
     * Define the Media name.
     *
     * @param int $id
     */
    public function setId($id);

    /**
     * Define the Media name.
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Define the Media file name.
     *
     * @param string $fileName
     */
    public function setFileName($fileName);

    /**
     * Define the Media file type (images, audio, video...).
     *
     * @param string $fileType
     */
    public function setFileType($fileType);

    /**
     * Define the Media type.
     *
     * @param string $type
     */
    public function setType($type);

    /**
     * Define the Media file size.
     *
     * @param int $size
     */
    public function setSize($size);

    /**
     * Define the Media description.
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * Return the Media id.
     *
     * @return string
     */
    public function getId();

    /**
     * Return the Media name.
     *
     * @return string
     */
    public function getName();

    /**
     * Return the Media file name.
     *
     * @return string
     */
    public function getFileName();

    /**
     * Return the Media file type.
     *
     * @return string
     */
    public function getFileType();

    /**
     * Return the Media file type.
     *
     * @return string
     */
    public function getType();

    /**
     * Return the Media file size.
     *
     * @return int
     */
    public function getSize();

    /**
     * Return the Media description.
     *
     * @return string
     */
    public function getDescription();
}
