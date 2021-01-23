<?php

namespace App\Form;

use App\Entity\ArticleCover;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleCoverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cover', FileType::class)
            ->add('copyright', TextType::class, array(
                'label'=>"Copyright de l'image",
                'attr'=>array(
                    'value'=>'©kubwacu',
                    'class'=>'articleCover-alt'
                )
            ))
            ->add('description', TextType::class, array(
                'label'=>"Description de l'image",
                'attr'=>array(
                    'placeholder'=>'P.e : Image de la ville de Bujumbura',
                    'class'=>'articleCover-alt'
                ) 
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleCover::class,
        ]);
    }
}
