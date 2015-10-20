<?php

namespace BlueBear\MediaBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Nameable;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Media
 *
 * @ORM\Table(name="cms_media")
 * @ORM\Entity(repositoryClass="BlueBear\MediaBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("name")
 */
class Media
{
    use Id, Nameable, Timestampable;

    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_FILE = 'file';

    /**
     * @ORM\Column(name="filepath", type="string")
     */
    protected $filepath;

    /**
     * @ORM\Column(name="filename", type="string")
     */
    protected $filename;

    /**
     * @ORM\Column(name="size", type="integer")
     */
    protected $size;

    /**
     * Media type
     *
     * @ORM\Column(name="type", type="string")
     */
    protected $type;

    protected $file;

    public function getExtension()
    {
        $array = explode('.', $this->filename);

        return array_pop($array);
    }

    /**
     * @return mixed
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @param mixed $filepath
     */
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
}
