<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr'  => [
                    'autocomplete' => 'off',
                    'class'        => 'col-md-6',
                ]
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Body',
                'attr'  => [
                    'autocomplete' => 'off',
                    'class'        => 'col-md-6'
                ]
            ])
            ->add('img', FileType::class, [
                'data_class' => null,
                'required'   => false,
                'label'      => 'Image',
                'attr'       => [
                    'autocomplete' => 'off',
                    'class'        => 'col-md-6'
                ]
            ])
            ->add('category', EntityType::class, [
                'class'        => Category::class,
                'placeholder'  => 'Choose an category',
                'choice_label' => 'title'
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
