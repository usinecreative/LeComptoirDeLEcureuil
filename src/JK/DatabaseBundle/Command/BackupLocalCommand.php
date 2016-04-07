<?php

namespace JK\DatabaseBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class BackupLocalCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected function configure()
    {
        $this
            ->setName('database:local:backup')
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
            $fileSystem->mkdir($backupDir);
        }


        $fileName = 'backup_%s_local_%s.sql';
        $fileName = sprintf(
            $fileName,
            $this->container->getParameter('database_name'),
            date('Y-m-d_h-i-s')
        );

        $commandLine = 'mysqldump -u %s -p%s  %s > %s';
        $commandLine = sprintf(
            $commandLine,
            $this->container->getParameter('database_user'),
            $this->container->getParameter('database_password'),
            $this->container->getParameter('database_name'),
            $backupDir . '/' . $fileName
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
