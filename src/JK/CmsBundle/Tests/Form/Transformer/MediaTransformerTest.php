<?php

namespace JK\CmsBundle\Tests\Form\Transformer;

use JK\CmsBundle\Entity\Media;
use JK\CmsBundle\Form\Transformer\MediaTransformer;
use JK\CmsBundle\Repository\MediaRepository;
use PHPUnit_Framework_TestCase;

class MediaTransformerTest extends PHPUnit_Framework_TestCase
{
    public function testTransform()
    {
        $media = new Media();
        $media->setId(666);
        $media->setFileName('test.devil');
        
        $repository = $this->getMock(MediaRepository::class, [], [], '', false);
        
        $repository
            ->method('find')
            ->willReturn($media);
        
        $transformer = new MediaTransformer($repository);
        $data = $transformer->transform($media);
    
        $this->assertEquals(666, $data['id']);
        $this->assertEquals('test.devil', $data['filename']);
    
        $compare = $transformer->reverseTransform($data);
        $this->assertEquals($media, $compare);
    }
}
