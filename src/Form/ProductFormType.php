<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null,[
                'label' => 'Title'
            ])
            ->add('image', null,[
                'label' => 'Inserer le nom de l\'image avec son extension'
            ])
            ->add('price', null,[
                'label' => 'Prix du produit'
            ])
            ->add('categorie', null,[
                'label' => 'Ajouter Categorie'
            ])
            ->add('description', null,[
                'label' => 'Description'
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
