<?php

namespace JK\CmsBundle\Form\Transformer;

use JK\CmsBundle\Form\Type\EditMediaType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class HtmlPropertyTransformer implements DataTransformerInterface
{
    protected $excludedAttributes = [];
    
    public function transform($data)
    {
        if (!is_array($data)) {
            throw new TransformationFailedException('Data should an array');
        }
        $excludedAttributes = [
            'class',
            'data-mce-src',
            'data-mce-selected',
        ];
        $defaultAttributes = [
            'height' => 150,
            'width' => 150,
        ];
        
        if (!key_exists('height', $data) || !key_exists('width', $data)) {
            $webDirectory = __DIR__.'/../../../../../web';
            $webDirectory = realpath($webDirectory);
    
            $relativePathPosition = strpos($data['src'], 'cache/resolve/raw/') + strlen('cache/resolve/raw/');
            $relativePath = substr($data['src'], $relativePathPosition);
            $imageSize = getimagesize($webDirectory.'/'.$relativePath);
    
            $data['width'] = $imageSize[0];
            $data['height'] = $imageSize[1];
        }
    
        if (key_exists('class', $data)) {
            if ('pull-'.EditMediaType::ALIGNMENT_FIT_TO_WIDTH === $data['class']) {
                $data['alignment'] = EditMediaType::ALIGNMENT_FIT_TO_WIDTH;
            } elseif ('pull-'.EditMediaType::ALIGNMENT_LEFT === $data['class']) {
                $data['alignment'] = EditMediaType::ALIGNMENT_LEFT;
            } elseif ('pull-'.EditMediaType::ALIGNMENT_RIGHT === $data['class']) {
                $data['alignment'] = EditMediaType::ALIGNMENT_RIGHT;
            } elseif ('pull-'.EditMediaType::ALIGNMENT_CENTER === $data['class']) {
                $data['alignment'] = EditMediaType::ALIGNMENT_CENTER;
            } elseif ('pull-'.EditMediaType::ALIGNMENT_CENTER === $data['class']) {
                $data['alignment'] = EditMediaType::ALIGNMENT_NONE;
            }
        }
        
        foreach ($data as $name => $value) {
            if (in_array(strtolower($name), $excludedAttributes)) {
                unset($data[$name]);
            }
        }
        $attributes = array_merge($defaultAttributes, $data);
        
        return $attributes;
    }
    
    public function reverseTransform($data)
    {
        if (!is_array($data)) {
            throw new TransformationFailedException('Data should an array');
        }
        unset($data['fit_to_width']);
        $data['style'] = '';
    
        if (key_exists('alignment', $data)) {
            //$data['style'] = 'class: pull-'.$data['alignment'].';';
    
            $data['class'] = 'pull-'.$data['alignment'];
            
            unset($data['alignment']);
        }
        $content = '<img';
    
        foreach ($data as $attribute => $value) {
            $content .= ' '.$attribute.'="'.$value.'"';
        }
        $content .= ' />';
        
        return $content;
    }
}
