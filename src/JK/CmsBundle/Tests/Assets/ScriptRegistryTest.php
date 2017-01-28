<?php

namespace JK\CmsBundle\Tests\Assets;

use Exception;
use JK\CmsBundle\Assets\ScriptRegistry;
use LAG\AdminBundle\Tests\AdminTestBase;
use Twig_Environment;

class ScriptRegistryTest extends AdminTestBase
{
    public function testRegister()
    {
        $twig = $this
            ->getMockBuilder(Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $twig
            ->method('render')
            ->willReturnCallback(function ($template, $parameters) {
                if ('@JKCms/Assets/script.template.html.twig' !== $template) {
                    return json_encode([
                        'template' => $template,
                        'parameters' => $parameters,
                    ]);
                }

                return '<script src="'.$parameters['script'].'"></script>';
            });
        $registry = new ScriptRegistry($twig);
        $registry->register('head', 'my_js.js');

        $this->assertContains('<script src="my_js.js"></script>', $registry->dumpScripts('head'));
        $this->assertEmpty($registry->dumpScripts('footer'));

        $registry->register('footer', 'footer.js');
        $this->assertContains('<script src="my_js.js"></script>', $registry->dumpScripts('head'));
        $this->assertContains('<script src="footer.js"></script>', $registry->dumpScripts('footer'));

        $registry->register('footer', 'test.js', 'my_template.twig.html', [
            'test' => true,
        ]);
        $this->assertContains('<script src="my_js.js"></script>', $registry->dumpScripts('head'));
        $this->assertContains('<script src="footer.js"></script>', $registry->dumpScripts('footer'));
        $this->assertContains(json_encode([
            'template' => 'my_template.twig.html',
            'parameters' => [
                'test' => true,
            ],
        ]), $registry->dumpScripts('footer'));

        $this->assertExceptionRaised(Exception::class, function () use ($registry) {
            $registry->dumpScripts('middle');
        });
    }
}
