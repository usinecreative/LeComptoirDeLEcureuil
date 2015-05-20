<?php

namespace BlueBear\CmsBundle\Command;

use BlueBear\CmsBundle\Connector\WordPressConnector;
use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends DoctrineCommand
{
    protected function configure()
    {
        $this
            ->setName('bluebear:cms:import')
            ->setDescription('Imports articles from various sources');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputFile = '/home/afrezet/Projets/LeComptoir/docs/input-wordpress.xml';

        if (!file_exists($inputFile)) {
            throw new Exception("Input file {$inputFile} not found");
        }
        $xml = simplexml_load_file($inputFile);
        $connector = new WordPressConnector($this->getContainer());
        $connector->importXml($xml);

    }
}
