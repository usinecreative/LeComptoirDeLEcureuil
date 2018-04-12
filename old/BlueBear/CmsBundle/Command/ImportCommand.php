<?php

namespace BlueBear\CmsBundle\Command;

use BlueBear\CmsBundle\Connector\WordPressConnector;
use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// TODO mettre à jour la commande
class ImportCommand extends DoctrineCommand
{
    protected function configure()
    {
        $this
            ->setName('bluebear:cms:import')
            ->addOption('path', 'p', InputOption::VALUE_REQUIRED, 'Absolute path to the source file')
            ->addOption('type', 't', InputOption::VALUE_OPTIONAL, 'Type of the source file (wordpress by default)', 'wordpress')
            ->setDescription('Imports articles from various sources');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // /home/afrezet/Projets/LeComptoir/docs/input-wordpress.xml
        $sourceFilePath = $input->getOption('path');
        $importType = $input->getOption('type');

        if (!file_exists($sourceFilePath)) {
            throw new Exception("Input file '{$sourceFilePath}' not found");
        }
        if ($importType == 'wordpress') {
            $output->writeln('Reading source file');
            $xml = simplexml_load_file($sourceFilePath);
            $output->writeln('Import data');
            $connector = new WordPressConnector($this->getContainer());
            $connector->importXml($xml);
            $output->writeln('Data successfully imported');
        } else {
            throw new Exception("Invalid source type $importType, available are wordpress");
        }
    }
}
