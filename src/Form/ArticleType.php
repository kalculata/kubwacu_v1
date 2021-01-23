<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder   
            ->add('lang', ChoiceType::class,array('choices'=>$this->langs()))
            ->add('category', EntityType::class, [
                'class' => ('App\Entity\ArticleCategory'),
                'choice_label' => 'name',])
            ->add('sub_category', ChoiceType::class,[]) 
            ->add('title',  TextareaType::class)
            ->add('introduction',  TextareaType::class)
            ->add('article', TextareaType::class)
            ->add('cover', ArticleCoverType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
    public function langs(){
        $langs = array(
            'fr'=>'Français',
            'kir'=>'Kirundi'
        );
        $outPut = [];
        foreach ($langs as $code => $notice) {
            $outPut[$notice]=$code;
        }
        return $outPut;
    }
}
