<?php

namespace BlueBear\CmsBundle\Factory;

use BlueBear\CmsBundle\Cms\ContentBehavior;
use BlueBear\CmsBundle\Cms\ContentType;
use Exception;

class ContentTypeFactory
{
    protected $contentTypes = [];

    protected $behaviors = [];

    /**
     * Initialize content type configuration.
     *
     * @param array $contentConfiguration
     *
     * @throws Exception
     */
    public function init(array $contentConfiguration)
    {
        $contentConfiguration = array_merge($this->getDefaultConfiguration(), $contentConfiguration);
        // load content behaviors
        if (array_key_exists('behaviors', $contentConfiguration)) {
            if (is_array($contentConfiguration['behaviors'])) {
                foreach ($contentConfiguration['behaviors'] as $behaviorName => $behaviorConfiguration) {
                    $behavior = new ContentBehavior();
                    $behavior->hydrateFromConfiguration($behaviorName, $behaviorConfiguration);
                    $this->behaviors[$behaviorName] = $behavior;
                }
            } else {
                throw new Exception('Content behaviors configuration should be an array');
            }
        }
        // type to inherit
        $toInherit = [];
        // load content types
        if (array_key_exists('types', $contentConfiguration)) {
            if (is_array($contentConfiguration['types'])) {
                foreach ($contentConfiguration['types'] as $typeName => $typeConfiguration) {
                    if (array_key_exists('parent', $typeConfiguration)) {
                        $toInherit[$typeName] = $typeConfiguration['parent'];
                    } else {
                        // create content type from configuration
                        $this->create($typeName, $typeConfiguration);
                    }
                }
            }
            // if content type must be inherited
            foreach ($toInherit as $typeName => $toInheritType) {
                // type to inherit should exists
                if (!in_array($toInheritType, array_keys($this->contentTypes))) {
                    throw new Exception("Invalid type to inherit \"{$toInheritType}\". Check your configuration");
                }
                // inherit current type configuration from parent type
                $typeConfiguration = array_merge_recursive($contentConfiguration['types'][$typeName], $contentConfiguration['types'][$toInheritType]);
                // create content type with merged configuration
                $this->create($typeName, $typeConfiguration);
            }
        }
    }

    /**
     * Create a content type from configuration.
     *
     * @param $typeName
     * @param $typeConfiguration
     *
     * @throws Exception
     */
    public function create($typeName, $typeConfiguration)
    {
        // try to guess field type if not defined
        $fields = $typeConfiguration['fields'];
        $typedFields = [];

        foreach ($fields as $fieldName => $field) {
            if (!$field) {
                $field = [];
            }
            $typedFields[$fieldName] = array_merge($this->getDefaultFieldConfiguration(), [
                'type' => $this->guessFieldType($fieldName, $field),
            ], $field);
        }
        $typeConfiguration['fields'] = $typedFields;
        $typeBehaviors = $typeConfiguration['behaviors'];
        $allowedBehaviors = array_keys($this->behaviors);

        // check if configured behavior for content type exists
        foreach ($typeBehaviors as $name => $typeBehavior) {
            if (!in_array($name, $allowedBehaviors)) {
                throw new Exception("Invalid behavior \"{$name}\" for content \"$typeName\"");
            }
            /** @var ContentBehavior $behavior */
            $behavior = $this->behaviors[$name];
            // adding behavior fields
            foreach ($behavior->getFields() as $fieldName => $fieldConfiguration) {
                if (!array_key_exists($fieldName, $fields)) {
                    $typeConfiguration['fields'][$fieldName] = array_merge($this->getDefaultFieldConfiguration(), $fieldConfiguration);
                }
            }
        }
        // create content type and hydrate it from configuration
        $type = new ContentType();
        $type->hydrateFromConfiguration($typeName, $typeConfiguration);
        // adding it to global content type collection
        $this->contentTypes[$typeName] = $type;
    }

    /**
     * Return default configuration.
     *
     * @return array
     */
    protected function getDefaultConfiguration()
    {
        return [
            'behaviors' => [
                'authorable' => [
                    'class' => 'BlueBear\CmsBundle\Cms\Content\Behaviors\Authorable',
                    'fields' => [
                        'author' => [
                            'type' => 'text',
                            'contribuable' => false,
                        ],
                    ],
                ],
                'timestampable' => [
                    'class' => 'BlueBear\CmsBundle\Cms\Content\Behaviors\Timestampable',
                    'fields' => [
                        'createdAt' => [
                            'type' => 'datetime',
                            'contribuable' => false,
                        ],
                        'updatedAt' => [
                            'type' => 'datetime',
                            'contribuable' => false,
                        ],
                    ],
                ],
                'publishable' => [
                    'class' => 'BlueBear\CmsBundle\Cms\Content\Behaviors\Publishable',
                    'fields' => [
                        'publishing_status' => [
                            'type' => 'text',
                            'contribuable' => false,
                        ],
                    ],
                ],
                'commentable' => [
                    'class' => 'BlueBear\CmsBundle\Cms\Content\Behaviors\Publishable',
                    'fields' => [
                        'hasComments' => [
                            'type' => 'choice',
                            'options' => [
                                'choices' => [true => 'bluebear.cms.yes', false => 'bluebear.cms.no'],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Return field default configuration.
     *
     * @return array
     */
    protected function getDefaultFieldConfiguration()
    {
        return [
            'contribuable' => true,
        ];
    }

    /**
     * Try to guess field type if not defined. It should be an Symfony form type.
     *
     * @param $fieldName
     * @param $field
     *
     * @return null|string
     */
    protected function guessFieldType($fieldName, $field)
    {
        $type = null;

        if ($field && array_key_exists('type', $field)) {
            $type = $field['type'];
        } else {
            if (in_array($fieldName, ['content'])) {
                $type = 'ckeditor';
            } elseif (in_array($fieldName, ['description'])) {
                $type = 'textarea';
            } else {
                $type = 'text';
            }
        }

        return $type;
    }

    /**
     * @return array
     */
    public function getContentTypes()
    {
        return $this->contentTypes;
    }

    /**
     * @param string $name
     *
     * @return ContentType
     *
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
