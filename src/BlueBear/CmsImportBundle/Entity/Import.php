<?php

namespace BlueBear\CmsImportBundle\Entity;

use BlueBear\BaseBundle\Entity\Behaviors\Id;
use BlueBear\BaseBundle\Entity\Behaviors\Label;
use BlueBear\BaseBundle\Entity\Behaviors\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Import
 *
 * Import from various sources
 *
 * @ORM\Table(name="cms_import")
 * @ORM\Entity(repositoryClass="BlueBear\CmsImportBundle\Repository\ImportRepository")
 */
class Import
{
    use Id, Label, Timestampable;

    const IMPORT_TYPE_WORDPRESS = 'wordpress';

    /**
     * Import type (Wordpress...)
     *
     * @ORM\Column(name="type", type="string", length=255)
     * @var string
     */
    protected $type;

    /**
     * The path to the import data file
     *
     * @ORM\Column(name="file_path", type="string")
     * TODO add an file assertion
     */
    protected $filePath;

    /**
     * @ORM\Column(name="file_name", type="string")
     */
    protected $fileName;

    protected $file;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
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

        if ($file instanceof UploadedFile) {
            $this->setfilePath($file->getPath());
            $this->setFileName($file->getFilename());
        }
    }

    /**
     * @return mixed
     */
    public function getfilePath()
    {
        return $this->filePath;
    }

    /**
     * @param mixed $filePath
     */
    public function setfilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
}
