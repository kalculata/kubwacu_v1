<?php

namespace App\Form;

use App\Entity\ArticleCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ArticleSubCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, [
                'class' => ('App\Entity\ArticleCategory'),
                'choice_label' => 'name',
                ])
            ->add('sub_category', TextType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleCategory::class
        ]);
    }
}
