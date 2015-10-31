<?php

namespace BlueBear\CmsBundle\Assetic\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\BaseProcessFilter;
use Assetic\Filter\FilterInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BundlerCompassFilter extends BaseProcessFilter implements FilterInterface
{
    protected $bundleCommand = 'bundle exec';

    /**
     * @var
     */
    protected $kernelRootDir;
    protected $cacheDir;
    protected $webDir;
    protected $imagesDir;
    protected $fontsDir;
    protected $jsDir;

    protected $environment;

    public function __construct($kernelRootDir, $cacheDir, $environment = 'dev')
    {
        $this->environment = $environment;
        $this->kernelRootDir = $kernelRootDir;
        $this->cacheDir = $cacheDir;
        $this->webDir = realpath($kernelRootDir . '/../web');
        $this->imagesDir = $this->webDir . '/img';
        $this->fontsDir = $this->webDir . '/fonts';
        $this->jsDir = $this->webDir . '/js';
    }

    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterLoad(AssetInterface $asset)
    {
        // TODO: Implement filterLoad() method.
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterDump(AssetInterface $asset)
    {
        $bundlerCommand = $this->getBundlerCommand();
        $compassCommand = $this->getCompassCommand($assetPath = $asset->getSourceRoot() . '/' . $asset->getSourcePath());




        //var_dump($bundlerCommand);
        var_dump($asset->getTargetPath());

        var_dump($bundlerCommand . $compassCommand);
        exec($bundlerCommand . $compassCommand, $ouput);
        var_dump($ouput);


        // TODO: Implement filterDump() method.

        die('dump');
    }

    protected function getBundlerCommand()
    {
        $workingDir = realpath($this->kernelRootDir . '/../');
        $bundlerCommand = "cd {$workingDir} && bundle exec ";

        return $bundlerCommand;
    }

    protected function getCompassCommand($filePath)
    {
        $action = 'compass compile';
        $cacheDir = $this->cacheDir . '/' . $this->environment;
        $imagesDir = $this->webDir . '/img';

        // generate config.rb compass configuration file
        $options = $this->getCompassOptions();
        $configurationFile = $this->generateCompassConfigurationFile($options);

        $command = "{$action} '{$cacheDir}' '--images-dir' '{$imagesDir}' '--config' '{$configurationFile}' '{$filePath}' --trace";
        /**
         * '/usr/bin/ruby' '/usr/local/bin/compass' 'compile' '/home/johnkrovitch/Projects/LeComptoir/app/cache/dev' '--boring' '--images-
        dir' '/home/johnkrovitch/Projects/LeComptoir/app/../web/img' '--config' '/home/johnkrovitch/Projects/LeComptoir/app/cache/dev/a
        ssetic_compassCOUiuH' '--sass-dir' '' '--css-dir' '' '/home/johnkrovitch/Projects/LeComptoir/app/cache/dev/assetic_compassqd4Py
        6.scss'
         *
         */
        return $command;
    }

    protected function getCompassOptions(array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'additional_import_paths' => '',
            'unix_newlines' => true,
            'debug_info' => false,
            'no_line_comments' => false,
            'cache_location' => $this->cacheDir,
            'no_cache' => false,
            'http_path' => $this->webDir,
            'http_images_path' => $this->imagesDir,
            'http_fonts_path' => $this->fontsDir,
            'http_generated_images_path' => $this->imagesDir . '/gen',
            'generated_images_path' => $this->imagesDir . '/gen2',
            'http_javascripts_path' => $this->jsDir,
            'relative_assets' => false
        ]);
        $options = $resolver->resolve($options);

        return $options;
    }

    protected function generateCompassConfigurationFile(array $options)
    {
        // creating filter cache dir
        $filterCacheDir = $this->cacheDir . '/assetic/filter/bundler';
        mkdir($filterCacheDir, 0777, true);
        // configuration temporary file
        $filepath = tempnam($filterCacheDir, 'config');
        $content = '';

        foreach ($options as $option => $value) {
            if ($value && count($value)) {
                $content .= "{$option} = \"{$value}\"" . "\n";
            }
        }
        file_put_contents($filepath, $content);

        return $filepath;
    }
}
