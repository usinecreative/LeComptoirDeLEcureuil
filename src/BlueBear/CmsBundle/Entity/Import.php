<?php

namespace BlueBear\CmsBundle\Entity;

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
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\ImportRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Import
{
    use Id, Label, Timestampable;

    const IMPORT_STATUS_SUCCESS = 'success';
    const IMPORT_STATUS_ERROR = 'error';
    const IMPORT_STATUS_IN_PROGRESS = 'in_progress';

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

    /**
     * @ORM\Column(name="status", type="string")
     */
    protected $status;

    /**
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    protected $comments;

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

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }
}
