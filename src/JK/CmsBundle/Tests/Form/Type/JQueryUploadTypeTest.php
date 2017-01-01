<?php

namespace JK\CmsBundle\Tests\Form\Type;

use JK\CmsBundle\Form\Transformer\MediaUploadTransformer;
use JK\CmsBundle\Form\Type\JQueryUploadType;
use Oneup\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class JQueryUploadTypeTest extends TypeTestCase
{
    public function testSubmittedData()
    {
        $form = $this
            ->factory
            ->create(JQueryUploadType::class);
        $form->submit([]);
        
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isSynchronized());
        
        $view = $form->createView();
        $this->assertCount(2, $view->children);
    
        foreach ($view->children as $name => $child) {
            $this->assertContains($name, ['id', 'upload']);
        }
    }
    
    protected function getExtensions()
    {
        $uploaderHelper = $this
            ->getMockBuilder(UploaderHelper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $uploadTransformer = $this
            ->getMockBuilder(MediaUploadTransformer::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $recaptchaType = new JQueryUploadType($uploaderHelper, $uploadTransformer);
        
        return [
            new PreloadedExtension([
                $recaptchaType
            ], []),
        ];
    }
}
