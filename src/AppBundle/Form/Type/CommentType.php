<?php

namespace AppBundle\Form\Type;

use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Repository\ArticleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var ArticleRepository $articleRepository */
        $articleRepository = $options['articleRepository'];

        $builder
            ->add('article', HiddenType::class)
            ->add('authorName', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Le nom sur la noisette...'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Laissez votre noisette ici...'
                ]
            ])
        ;

        $builder
            ->get('article')
            ->addModelTransformer(new CallbackTransformer(function (Article $article) {
                    return $article->getId();
                }, function ($id) use ($articleRepository) {
                    return $articleRepository
                        ->find($id);
                })
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label' => 'lecomptoir.post_comments'
            ])
            ->setRequired([
                'articleRepository'
            ])
            ->setAllowedTypes('articleRepository', ArticleRepository::class);
    }
}
