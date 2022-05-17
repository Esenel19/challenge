<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
         TextField::new('title'),
         
         ImageField::new('image')
         ->setBasePath('uploads')
         ->setUploadDir('public/upl oads')
         ->setUploadedFileNamePattern('[randomhash].[extension]')
         ->setRequired(false),
         TextField::new('subtitle'),
         TextareaField::new('description'),
         //BooleanField::new('isDest'),
        //  MoneyField::new('price')
        //  ->setCurrency('EUR'),
         AssociationField::new('categorie')
        ];
     }
}
