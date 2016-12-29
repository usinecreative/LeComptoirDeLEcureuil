<?php

namespace JK\CmsBundle\Tests\Form\Extension;

use Exception;
use JK\CmsBundle\Assets\ScriptRegistry;
use JK\CmsBundle\Form\Extension\AssetsExtension;
use LAG\AdminBundle\Tests\AdminTestBase;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

class AssetsExtensionTest extends AdminTestBase
{
    public function testAssetsExtension()
    {
        $loadedScripts = [
            'head' => [],
            'footer' => [],
        ];
        /** @var ScriptRegistry|PHPUnit_Framework_MockObject_MockObject $registry */
        $registry = $this
            ->getMockBuilder(ScriptRegistry::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $registry
            ->method('register')
            ->willReturnCallback(function($location, $script) use (&$loadedScripts) {
                $loadedScripts[$location][$script] = $script;
            })
        ;
    
        $view = new FormView();
    
        /** @var Form|PHPUnit_Framework_MockObject_MockObject $form */
        $form = $this
            ->getMockBuilder(Form::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $view->vars['scripts'] = [
            'head' => 'test.js'
        ];
        $extension = new AssetsExtension($registry);
    
        // an exception should be thrown if an invalid configuration is given
        $this->assertExceptionRaised(Exception::class, function() use ($extension, $view, $form) {
            $extension->finishView($view, $form, []);
        });
        $this->assertCount(0, $loadedScripts['head']);
        $this->assertCount(0, $loadedScripts['footer']);
    
        $view->vars['scripts'] = [
            'head' => [
                'test.js',
                'test2.js' => [
                    'template' => 'test.twig',
                    'context' => [
                        'myVar' => 23
                    ],
                ]
            ],
        ];
        $extension->finishView($view, $form, []);
        
        $this->assertCount(2, $loadedScripts['head']);
        $this->assertArrayHasKey('test.js', $loadedScripts['head']);
        $this->assertArrayHasKey('test2.js', $loadedScripts['head']);
        $this->assertCount(0, $loadedScripts['footer']);
    
        $view->vars['scripts'] = [
            'footer' => [
                'test.js' => []
            ]
        ];
        $extension->finishView($view, $form, []);
    
        $this->assertEquals(FormType::class, $extension->getExtendedType());
    }
}
