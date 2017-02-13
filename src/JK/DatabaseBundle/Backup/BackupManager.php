<?php

namespace JK\DatabaseBundle\Backup;

use DateTime;
use JK\DatabaseBundle\Configuration\DatabaseConfiguration;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\Process;

/**
 * Handle database backup and cleaning.
 */
class BackupManager
{
    /**
     * @var array
     */
    private $databaseConfiguration;
    
    /**
     * @var string
     */
    private $backupFilenamePattern;
    
    /**
     * @var int
     */
    private $backupToKeep;
    
    /**
     * BackupManager constructor.
     *
     * @param array $databaseConfiguration
     * @param string $backupFilenamePattern
     * @param int $backupToKeep
     */
    public function __construct(
        array $databaseConfiguration = [],
        $backupFilenamePattern = '%s_%s_backup-%s.sql',
        $backupToKeep = 5
    ) {
        $this->databaseConfiguration = $databaseConfiguration;
        $this->backupToKeep = $backupToKeep;
        $this->backupFilenamePattern = $backupFilenamePattern;
    }
    
    /**
     * Create a database backup in the given directory using the given database configuration.
     *
     * @param array $databaseConfiguration
     * @param $backupDirectory
     *
     * @return string
     */
    public function backup(array $databaseConfiguration, $backupDirectory)
    {
        $configuration = $this->resolveDatabaseConfiguration($databaseConfiguration);
        
        // the backup directory must exists
        if (!file_exists($backupDirectory)) {
            throw new FileNotFoundException('Backup directory not found: '.$backupDirectory);
        }
        
        // add the trailing slash
        if ('/' !== substr($backupDirectory, -1)) {
            $backupDirectory .= '/';
        }
        
        // get backup file path
        $backupPath = $this->getBackupPath($backupDirectory, $configuration);
        
        // create mysqldump command name
        $command = $this->getMysqlCommandLine($configuration, $backupPath);
        
        // execute the command
        $process = new Process($command);
        $process->mustRun();
    
        $this->clean($backupDirectory);
    
        return $backupPath;
    }
    
    /**
     * Resolve the database configuration.
     *
     * @param array $databaseConfiguration
     *
     * @return DatabaseConfiguration
     */
    private function resolveDatabaseConfiguration(array $databaseConfiguration)
    {
        $databaseConfiguration = array_merge($this->databaseConfiguration, $databaseConfiguration);
        $resolver = new OptionsResolver();
    
        $configuration = new DatabaseConfiguration();
        $configuration->configureOptions($resolver);
        $configuration->setParameters($resolver->resolve($databaseConfiguration));
    
        return $configuration;
    }
    
    /**
     * Return the mysqldump command from the configuration parameters.
     *
     * @param DatabaseConfiguration $configuration
     * @param $backupPath
     *
     * @return string
     */
    private function getMysqlCommandLine(DatabaseConfiguration $configuration, $backupPath)
    {
        $baseCommand = 'mysqldump';
        
        // add user/password parameters
        $command = $baseCommand.' -u '.$configuration->getParameter('user');
        $command .= ' -p'.$configuration->getParameter('password');
    
        // add the host if provided
        if ($configuration->getParameter('host')) {
            $command .= ' -h '.$configuration->getParameter('host');
        }
    
        if ($configuration->getParameter('port')) {
            $command .= ' -P '.$configuration->getParameter('port');
        }
    
        // add the database name
        $command .= ' '.$configuration->getParameter('name');
        
        // add the backup path
        $command .= ' > '.$backupPath;
    
        return $command;
    }
    
    /**
     * Return the backup file path.
     *
     * @param $backupDirectory
     * @param DatabaseConfiguration $configuration
     *
     * @return string
     */
    private function getBackupPath($backupDirectory, DatabaseConfiguration $configuration)
    {
        $createdAt = new DateTime();
        
        $filename = sprintf(
            $this->backupFilenamePattern,
            $configuration->getParameter('host'),
            $configuration->getParameter('name'),
            $createdAt->format('Y-m-d_h-i-s')
        );
    
        return $backupDirectory.$filename;
    }
    
    /**
     * Remove the backup according to the number of backups to keep.
     *
     * @param $backupDirectory
     */
    private function clean($backupDirectory)
    {
        $searchPattern = str_replace('%s', '*', $this->backupFilenamePattern);
        
        $finder = new Finder();
        $finder
            ->files()
            ->name($searchPattern)
            ->in($backupDirectory)
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
    
            if ($toKeep >= $this->backupToKeep) {
                $fileSystem->remove($file);
            }
            $toKeep++;
        }
    }
}
