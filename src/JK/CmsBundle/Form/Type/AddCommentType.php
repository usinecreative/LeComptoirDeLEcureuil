<?php

namespace JK\CmsBundle\Form\Type;

use BlueBear\CmsBundle\Entity\Comment;
use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Form\Constraint\AddComment;
use JK\CmsBundle\Repository\ArticleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommentType extends AbstractType
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    
    /**
     * AddCommentType constructor.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $articleTransformation = function (Article $article) {
            return $article->getId();
        };
        $articleReverseTransformation = function($id) {
            return $this
                ->articleRepository
                ->find($id);
        };
    
        $builder
            ->add('article', HiddenType::class)
            ->add('authorName', TextType::class, [
                'label' => 'Votre Nom',
                'attr' => [
                    'placeholder' => 'Votre nom...'
                ]
            ])
            ->add('authorUrl', TextType::class, [
                'label' => 'L\'adresse de votre blog, site...',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Un blog, un site ?'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre commentaire',
                'attr' => [
                    'placeholder' => 'Laissez votre commentaire ici...'
                ],
            ])
            ->add('notifyNewComments', CheckboxType::class, [
                'label' => 'Etre notifié des nouveaux comentaires',
                'required' => false,
            ])
            ->add('authorEmail', EmailType::class, [
                'label' => 'Votre email (si vous voulez être notifié des réponses à votre commentaire)',
                'attr' => [
                    'placeholder' => 'Votre email...'
                ],
                'required' => false,
            ])
            ->add('recaptcha', RecaptchaType::class, [
                'label' => false,
                'mapped' => false,
            ])
        ;
    
        $builder
            ->get('article')
            ->addModelTransformer(new CallbackTransformer($articleTransformation, $articleReverseTransformation));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Comment::class,
                'constraints' => new AddComment(),
                'label' => false,
            ])
        ;
    }
}
