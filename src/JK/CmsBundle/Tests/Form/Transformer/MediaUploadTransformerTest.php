<?php

namespace JK\CmsBundle\Tests\Form\Transformer;

use JK\CmsBundle\Entity\Media;
use JK\CmsBundle\Form\Transformer\MediaUploadTransformer;
use JK\CmsBundle\Repository\MediaRepository;
use PHPUnit_Framework_TestCase;

class MediaUploadTransformerTest extends PHPUnit_Framework_TestCase
{
    public function testTransform()
    {
        $media = new Media();
        $media->setId(666);
        $media->setFileName('test.devil');
        /** @var MediaRepository|\PHPUnit_Framework_MockObject_MockObject $repository */
        $repository = $this->getMock(MediaRepository::class, [], [], '', false);
        
        $repository
            ->method('find')
            ->willReturn($media);
        
        $transformer = new MediaUploadTransformer($repository);
        $data = $transformer->transform($media);
    
        $this->assertEquals(666, $data['id']);
        $this->assertEquals('test.devil', $data['filename']);
    
        $compare = $transformer->reverseTransform($data);
        $this->assertEquals($media, $compare);
    }
}
