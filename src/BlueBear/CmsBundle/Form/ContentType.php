<?php

namespace BlueBear\CmsBundle\Form;


use BlueBear\CmsBundle\Entity\Content;
use BlueBear\CmsBundle\Factory\ContentTypeFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ContentType extends AbstractType
{
    /**
     * @var ContentTypeFactory
     */
    protected $contentTypeFactory;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            /** @var Content $content */
            $content = $event->getData();
            $fields = $content->getFields();
            $form = $event->getForm();
            $fieldsType = $this->contentTypeFactory->getContentType($content->getType())->getFields();

            foreach ($fields as $fieldName => $fieldValue) {

                if ($fieldsType[$fieldName]['contribuable']) {
                    $options = array_key_exists('options', $fieldsType[$fieldName]) ? $fieldsType[$fieldName]['options'] : [];
                    $options['property_path'] = null;

                    $form->add($fieldName, $fieldsType[$fieldName]['type'], $options);
                }
            }
        });
    }

    public function getName()
    {
        return 'content';
    }

    /**
     * @param ContentTypeFactory $contentTypeFactory
     */
    public function setContentTypeFactory($contentTypeFactory)
    {
        $this->contentTypeFactory = $contentTypeFactory;
    }
}