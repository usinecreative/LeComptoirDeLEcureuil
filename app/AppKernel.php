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
            new Symfony\Bundle\WebServerBundle\WebServerBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            
            // Nuts
            new AppBundle\AppBundle(),
            new LeComptoirDeLEcureuil\BackBundle\LeComptoirDeLEcureuilBackBundle(),
    
            // CMS
            new LAG\AdminBundle\LAGAdminBundle(),
            new JK\CmsBundle\JKCmsBundle(),
            new Http\HttplugBundle\HttplugBundle(),
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new BlueBear\CmsBundle\BlueBearCmsBundle(),
            new BlueBear\MediaBundle\BlueBearMediaBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new JK\DatabaseBundle\JKDatabaseBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
    
            // Assets
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Oneup\UploaderBundle\OneupUploaderBundle(),
            new JK\SamBundle\JKSamBundle(),
            new Eko\FeedBundle\EkoFeedBundle(),
            new Dunglas\ActionBundle\DunglasActionBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();

            $bundles[] = new Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle();
            $bundles[] = new Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle();
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
