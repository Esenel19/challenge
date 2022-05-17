<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Nom de l\'activitée',
                'require' => 'true'
                ]
            ])
        ->add('description', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Description',
            ]
        ])
        ->add('image', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Lien image',
                'required' =>false,
                ]
            ])
        ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'title',
                'attr' => [
                'class' => 'form-select',
                'placeholder' => 'Categorie',
                ]
            
        ])
            
        ;
    }

    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class
        ]);
    }
}
