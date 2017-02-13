<?php

namespace JK\DatabaseBundle\Archive;

use SplFileInfo;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

/**
 * Archive a backup file and clean archives.
 */
class ArchiveManager
{
    /**
     * @var int
     */
    private $numberOfArchivesToKeep;
    
    /**
     * ArchiveManager constructor.
     *
     * @param int $numberOfArchivesToKeep
     */
    public function __construct($numberOfArchivesToKeep = 5)
    {
        $this->numberOfArchivesToKeep = $numberOfArchivesToKeep;
    }
    
    /**
     * Archive a backup $path and clean archives.
     *
     * @param $path
     *
     * @return string
     */
    public function archive($path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException('Backup not found at '.$path);
        }
        $archive = $this->getArchiveName($path);
        $command = $this->getArchiveCommand($archive, $path);
    
        $process = new Process($command);
        $process->mustRun();
    
        $this->clean(dirname($path));
    
        return $archive;
    }
    
    /**
     * Remove old archives.
     *
     * @param $directory
     */
    public function clean($directory)
    {
        $searchPattern = str_replace('%s', '*', '%s_%s_backup-%s.7z');
        
        $finder = new Finder();
        $finder
            ->files()
            ->name($searchPattern)
            ->in($directory)
            ->sortByName()
        ;
        $files = [];
        
        foreach ($finder as $fileInfo) {
            $files[] = $fileInfo;
        }
        $fileSystem = new Filesystem();
        $files = array_reverse($files);
        $toKeep = 0;
        
        foreach ($files as $file) {
            
            if ($toKeep >= $this->numberOfArchivesToKeep) {
                $fileSystem->remove($file);
            }
            $toKeep++;
        }
    }
    
    /**
     * Return a archive name from a file path.
     *
     * @param $path
     *
     * @return string
     */
    private function getArchiveName($path)
    {
        $fileInfo = new SplFileInfo($path);
        
        // replace .sql by .7z
        $archivePath = str_replace($fileInfo->getExtension(), '7z', $fileInfo);
    
        return $archivePath;
    }
    
    /**
     * Return the command to archive a file.
     *
     * @param $archivePath
     * @param $path
     *
     * @return string
     */
    private function getArchiveCommand($archivePath, $path)
    {
        // create 7z archive command ("a" for add)
        $command = '7z a '.$archivePath.' '.$path;
    
        return $command;
    }
}
