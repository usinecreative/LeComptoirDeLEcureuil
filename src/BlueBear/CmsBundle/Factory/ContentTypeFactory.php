<?php

namespace BlueBear\CmsBundle\Factory;

use BlueBear\CmsBundle\Cms\ContentBehavior;
use BlueBear\CmsBundle\Cms\ContentType;
use Exception;

class ContentTypeFactory
{
    protected $contentTypes = [];

    public function init(array $contentConfiguration)
    {
        $behaviors = [];
        $contentConfiguration = array_merge($this->getDefaultConfiguration(), $contentConfiguration);
        // load content behaviors
        if (array_key_exists('behaviors', $contentConfiguration)) {
            if (is_array($contentConfiguration['behaviors'])) {
                foreach ($contentConfiguration['behaviors'] as $behaviorName => $behaviorConfiguration) {
                    $behavior = new ContentBehavior();
                    $behavior->hydrateFromConfiguration($behaviorName, $behaviorConfiguration);
                    $behaviors[$behaviorName] = $behavior;
                }
            } else {
                throw new Exception('Content behaviors configuration should be an array');
            }
        }
        $allowedBehaviors = array_keys($behaviors);

        // load content types
        if (array_key_exists('types', $contentConfiguration)) {
            if (is_array($contentConfiguration['types'])) {

                foreach ($contentConfiguration['types'] as $typeName => $typeConfiguration) {
                    $type = new ContentType();
                    $type->hydrateFromConfiguration($typeName, $typeConfiguration);
                    $typeBehaviors = $type->getBehaviors();

                    foreach ($typeBehaviors as $name => $typeBehavior) {
                        if (!in_array($name, $allowedBehaviors)) {
                            throw new Exception("Invalid behavior \"{$name}\" for content \"$typeName\"");
                        }
                    }
                    $this->contentTypes[strtolower($typeName)] = $type;
                }
            }
        }
        // TODO inherits from parent
    }

    public function create()
    {

    }

    protected function getDefaultConfiguration()
    {
        return [
            'behaviors' => [
                'authorable' => [
                    'class' => 'BlueBear\CmsBundle\Cms\Content\Behaviors\Authorable'
                ],
                'timestampable' => [
                    'class' => 'BlueBear\CmsBundle\Cms\Content\Behaviors\Timestampable'
                ],
                'publishable' => [
                    'class' => 'BlueBear\CmsBundle\Cms\Content\Behaviors\Publishable'
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function getContentTypes()
    {
        return $this->contentTypes;
    }

    /**
     * @param $name
     * @return ContentType
     * @throws Exception
     */
    public function getContentType($name)
    {
        if (!array_key_exists($name, $this->contentTypes)) {
            throw new Exception("Content type {$name} not found. Check your configuration");
        }
        return $this->contentTypes[$name];
    }
}