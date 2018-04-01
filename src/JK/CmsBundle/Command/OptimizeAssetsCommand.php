<?php

namespace JK\CmsBundle\Command;

use ImageOptimizer\OptimizerFactory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

class OptimizeAssetsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cms:assets:optimize')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $style->title('CMS - Optimize Assets');
        $assetsDirectories = [
            $this->getContainer()->getParameter('kernel.project_dir').'/web/img',
            $this->getContainer()->getParameter('kernel.project_dir').'/web/images',
        ];

        $finder = new Finder();
        $finder
            ->in($assetsDirectories)
            ->files()
            ->name('*.jpg')
            ->name('*.png')
        ;
        $factory = new OptimizerFactory();
        $optimizer = $factory->get();

        foreach ($finder as $file) {
            $style->text('Optimize '.$file->getRealPath());
            $optimizer->optimize($file->getRealPath());
        }
    }
}
