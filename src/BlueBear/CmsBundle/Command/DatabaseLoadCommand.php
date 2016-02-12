<?php

namespace BlueBear\CmsBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use ZipArchive;

class DatabaseLoadCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setName('dizda:backup:load')
            ->setDescription('Load a backup made by dizda cloudbackup bundle')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputArray = [];
        $rootPath = realpath($this->container->getParameter('kernel.root_dir') . '/../dumps');

        // find 7z archives in dump directory
        $finder = new Finder();
        $finder
            ->name('*.7z')
            ->files()
            ->in($rootPath)
            ->sort(function (SplFileInfo $file1, SplFileInfo $file2) {
                return $file1->getATime() < $file2->getATime();
            })
        ;
        // find last dump
        $lastModifiedArchive = null;

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $lastModifiedArchive = $file;
            break;
        }
        // extract last dump into cache directory
        $zipExtractCommand = '7za e %s -o%s -y';

        $command = sprintf(
            $zipExtractCommand,
            $lastModifiedArchive->getRealPath(),
            $this->container->getParameter('kernel.cache_dir') . '/mysql'
        );
        $output->writeln('Executing : ' . $command);
        exec($command, $outputArray);
        $output->writeln($outputArray);


        $finder = new Finder();
        $finder
            ->in($this->container->getParameter('kernel.cache_dir') . '/mysql')
            ->files()
            ->name('*.sql');

        $mysqlImportCommand = 'mysql -u %s -p%s %s < %s';

        foreach ($finder as $file) {
            $outputArray = [];

            $mysqlImportCommand = sprintf(
                $mysqlImportCommand,
                $this->container->getParameter('database_user'),
                $this->container->getParameter('database_password'),
                $this->container->getParameter('database_name'),
                $file->getRealPath()
            );
            $mysqlImportCommand = str_replace(
                $this->container->getParameter('database_password'),
                '**********',
                $mysqlImportCommand
            );
            $output->writeln('Executing : ' . $mysqlImportCommand);
            exec($mysqlImportCommand, $outputArray);
            $output->writeln($outputArray);
        }
        $output->writeln('Removing extracted sql dump file');
        $fileSystem = new Filesystem();
        $fileSystem->remove($this->container->getParameter('kernel.cache_dir') . '/mysql');
    }
}
