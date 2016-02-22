<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            //new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            // BlueBear
            new LAG\AdminBundle\LAGAdminBundle(),
            new BlueBear\CmsBundle\BlueBearCmsBundle(),
            new BlueBear\MediaBundle\BlueBearMediaBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            //new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            // Noisettes
            //new AppBundle\LeComptoirDeLEcureuilFrontBundle(),
            new LeComptoirDeLEcureuil\BackBundle\LeComptoirDeLEcureuilBackBundle(),
            new LeComptoirDeLEcureuil\CoreBundle\LeComptoirDeLEcureuilCoreBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            // Admin dev
            new LAG\DoctrineRepositoryBundle\LAGDoctrineRepositoryBundle(),
            new BlueBear\BaseBundle\BlueBearBaseBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new \Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),


            //new JK\StaticClientBundle\JKStaticClientBundle(),
            new \WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new AppBundle\AppBundle(),

            new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new \Dizda\CloudBackupBundle\DizdaCloudBackupBundle(),


        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Hautelook\AliceBundle\HautelookAliceBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
