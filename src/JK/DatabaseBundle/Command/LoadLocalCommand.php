<?php

namespace JK\DatabaseBundle\Command;

use LogicException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Process;

class LoadLocalCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected function configure()
    {
        $this
            ->setName('database:local:load')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->container->hasParameter('backup_dir')) {
            $backupDir = $this->container->getParameter('backup_dir');
        } else {
            $backupDir = 'backups';
        }
        $fileSystem = new Filesystem();

        if (!$fileSystem->exists($backupDir)) {
            throw new LogicException('Invalid backups directory');
        }

        $finder = new Finder();
        $finder
            ->in($backupDir)
            ->files()
            ->name('backup_*_local_*.sql')
            ->sortByAccessedTime()
        ;
        $lastBackup = null;

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            // get last file
            $lastBackup = $file;
        }

        $commandLine = 'mysql -u %s -p%s  %s < %s';
        $commandLine = sprintf(
            $commandLine,
            $this->container->getParameter('database_user'),
            $this->container->getParameter('database_password'),
            $this->container->getParameter('database_name'),
            $lastBackup->getRealPath()
        );

        $process = new Process($commandLine);
        $process->mustRun();
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
