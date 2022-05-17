<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
         TextField::new('name'),
         SlugField::new('slug')
         ->setTargetFieldName('name'),
         ImageField::new('illustration')
         ->setBasePath('uploads')
         ->setUploadDir('public/uploads')
         ->setUploadedFileNamePattern('[randomhash].[extension]')
         ->setRequired(false),
         TextField::new('subtitle'),
         TextareaField::new('description'),
         //BooleanField::new('isDest'),
         MoneyField::new('price')
         ->setCurrency('EUR'),
         AssociationField::new('category')
        ];
     }
}
