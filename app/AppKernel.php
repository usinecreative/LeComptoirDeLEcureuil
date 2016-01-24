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
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            // BlueBear
            new BlueBear\BaseBundle\BlueBearBaseBundle(),
            new LAG\AdminBundle\LAGAdminBundle(),
            new BlueBear\CmsBundle\BlueBearCmsBundle(),
            new BlueBear\CmsUserBundle\BlueBearCmsUserBundle(),
            new BlueBear\CmsImportBundle\BlueBearCmsImportBundle(),
            new BlueBear\MediaBundle\BlueBearMediaBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            // Noisettes
            new LeComptoirDeLEcureuil\FrontBundle\LeComptoirDeLEcureuilFrontBundle(),
            new LeComptoirDeLEcureuil\BackBundle\LeComptoirDeLEcureuilBackBundle(),
            new LeComptoirDeLEcureuil\CoreBundle\LeComptoirDeLEcureuilCoreBundle(),
            new LAG\DoctrineRepositoryBundle\LAGDoctrineRepositoryBundle(),
            //new JK\StaticClientBundle\JKStaticClientBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new \Hautelook\AliceBundle\HautelookAliceBundle();
        }
        if (in_array($this->getEnvironment(), ['prod'])) {
            $bundles[] = new \Ekino\Bundle\NewRelicBundle\EkinoNewRelicBundle();
        }

        return $bundles;
    }
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
