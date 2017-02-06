<?php

namespace JK\CmsBundle\Tests\Form\Transformer;

use BlueBear\CmsBundle\Entity\Tag;
use BlueBear\CmsBundle\Repository\TagRepository;
use JK\CmsBundle\Form\Transformer\TagCollectionTransformer;
use LAG\AdminBundle\Tests\AdminTestBase;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagCollectionTransformerTest extends AdminTestBase
{
    /**
     * On transform, the transformer should return a string from a Tags list.
     */
    public function testTransform()
    {
        $tagRepository = $this
            ->getMockBuilder(TagRepository::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $tag1 = new Tag();
        $tag1->setName('bamboo');
        $tag2 = new Tag();
        $tag2->setName('eating');
        
        $transformer = new TagCollectionTransformer($tagRepository);
        $transformer->transform([
            $tag1,
            $tag2,
        ]);
        
        $this->assertExceptionRaised(TransformationFailedException::class, function() use ($transformer) {
            $transformer->transform('a string');
        });
    }
    
    /**
     * On reverse transform, the transformer should return a list of Tags from a string.
     */
    public function testReverseTransform()
    {
        $tag1 = new Tag();
        $tag1->setName('bamboo');
        $tag2 = new Tag();
        $tag2->setName('eating');
        $tag3 = new Tag();
        $tag3->setName('panda');
        
        $tagRepository = $this
            ->getMockBuilder(TagRepository::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $tagRepository
            ->expects($this->exactly(4))
            ->method('findOneBy')
            ->willReturnMap([
                ['bamboo', $tag1],
                ['eating', $tag2],
                ['panda', $tag3],
            ])
        ;
        $transformer = new TagCollectionTransformer($tagRepository);
        $tags = $transformer->reverseTransform('bamboo, eating, panda, mountains');
        $this->assertCount(4, $tags);
        
        foreach ($tags as $tag) {
            $this->assertContains($tag->getName(), [
                'bamboo',
                'eating',
                'panda',
                'mountains',
            ]);
        }
    
        $this
            ->assertExceptionRaised(TransformationFailedException::class, function() use ($transformer) {
                $transformer->reverseTransform([
                    'tags, lol',
                ]);
            });
    }
}
