<?php

namespace JK\CmsBundle\Tests\Form\Type;

use JK\CmsBundle\Form\Type\RecaptchaType;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class RecaptchaTypeTest extends TypeTestCase
{
    public function testSubmittedData()
    {
        $form = $this
            ->factory
            ->create(RecaptchaType::class);
        $form->submit([]);
        
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isSynchronized());
        
        $view = $form->createView();
    
        $this->assertArrayHasKey('scripts', $view->vars);
        $this->assertArrayHasKey('head', $view->vars['scripts']);
        $this->assertContains('https://www.google.com/recaptcha/api.js', $view->vars['scripts']['head']);
    }
    
    protected function getExtensions()
    {
        $recaptchaType = new RecaptchaType('my-site-key');
        
        return [
            new PreloadedExtension([
                $recaptchaType
            ], []),
        ];
    }
}
